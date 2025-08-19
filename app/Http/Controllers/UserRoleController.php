<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    /**
     * Check if the current user is an admin or owner.
     */
    private function checkAdminPermission()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        // Allow: admins (employee or super_admin via isAdmin) and owner
        if (!(Auth::user()->isAdmin() || Auth::user()->hasRole('owner'))) {
            abort(403, 'Unauthorized. Only administrators can manage users and roles.');
        }
    }

    /**
     * Check if the current user can delete the target user.
     */
    private function checkDeletePermission($targetUser)
    {
        $currentUser = Auth::user();
        
        // Only admin or owner can delete users
        if (!$currentUser->hasRole('employee') && !$currentUser->hasRole('owner')) {
            abort(403, 'Unauthorized. Only administrators can delete users.');
        }
        
        // Admin cannot delete themselves
        if ($targetUser->id === $currentUser->id) {
            abort(403, 'You cannot delete yourself.');
        }
        
        // Admin/Owner can delete regular users but not other admins/owners
        if ($targetUser->hasRole('employee') || $targetUser->hasRole('owner')) {
            abort(403, 'You cannot delete other administrative users.');
        }
        
        return true;
    }
    /**
     * Update the roles assigned to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->checkAdminPermission();
        
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        $validator = Validator::make($request->all(), [
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permissions')
                ->withErrors($validator)
                ->withInput();
        }

        $roleIds = $request->input('roles', []);
        $roles = Role::whereIn('id', $roleIds)->get();
        
        // Prevent regular admin from assigning super_admin role
        if (!$currentUser->isSuperAdmin()) {
            foreach ($roles as $role) {
                if ($role->name === 'super_admin') {
                    return redirect()->route('permissions')
                        ->with('error', 'Only super admin can assign super admin role.');
                }
            }
            
            // If the target user is currently super_admin, allow modification ONLY to remove super_admin
            if ($user->isSuperAdmin()) {
                $incomingHasSuperAdmin = $roles->contains('name', 'super_admin');
                if ($incomingHasSuperAdmin) {
                    return redirect()->route('permissions')
                        ->with('error', 'Only super admin can modify super admin users.');
                }
                // else: allowed to update (drop super_admin)
            }
        }
        
        // Prevent user from removing their own super admin role
        if ($currentUser->id === $user->id && $currentUser->isSuperAdmin()) {
            $hasSuperAdminRole = $roles->contains('name', 'super_admin');
            if (!$hasSuperAdminRole) {
                return redirect()->route('permissions')
                    ->with('error', 'You cannot remove your own super admin role.');
            }
        }

        $user->roles()->sync($roleIds);

        return redirect()->route('permissions')
            ->with('success', 'User roles updated successfully.');
    }

    /**
     * Get users with their assigned roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsersWithRoles()
    {
        $this->checkAdminPermission();
        
        $users = User::with('roles')->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('permissions', compact('users', 'roles', 'permissions'));
    }
    
    /**
     * Show the form for editing the user's roles.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkAdminPermission();

        $userToDelete = User::findOrFail($id);
        $currentUser = Auth::user();

        // Rule: Nobody can delete themselves.
        if ($userToDelete->id === $currentUser->id) {
            return redirect()->route('permissions')->with('error', 'You cannot delete your own account.');
        }

        // Rule: Regular admin cannot delete a super_admin or another admin.
        if ($currentUser->hasRole('employee') && !$currentUser->hasRole('super_admin')) {
            if ($userToDelete->hasRole('super_admin') || $userToDelete->hasRole('employee')) {
                return redirect()->route('permissions')->with('error', 'You do not have permission to delete this user.');
            }
        }
        
        // Rule: Super admin can delete anyone (except themselves, checked above), but not another super_admin.
        if ($userToDelete->hasRole('super_admin')) {
             return redirect()->route('permissions')->with('error', 'Super admin users cannot be deleted.');
        }
        
        // If all checks pass, delete the user.
        $userToDelete->delete();

        return redirect()->route('permissions')->with('success', 'User deleted successfully.');
    }
}