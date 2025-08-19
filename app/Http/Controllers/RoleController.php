<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of roles and permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user has permissions (employee, owner, or super_admin)
        if (!Auth::user()->hasRole('employee') && !Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized access.');
        }

        $roles = Role::with('permissions')->get();
        $users = User::with('roles')->get();
        $permissions = Permission::all();
        
        return view('permissions', compact('roles', 'users', 'permissions'));
    }

    /**
     * Ensure 'employee' and 'user' roles exist.
     *
     * @return \Illuminate\Http\Response
     */
    public function setupDefaultRoles()
    {
        $defaultRoles = ['employee', 'user'];

        foreach ($defaultRoles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        return redirect()->route('roles')->with('success', 'Default roles (admin and user) have been created.');
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user has admin permissions
        if (!Auth::user()->hasRole('employee') && !Auth::user()->hasRole('owner')) {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permissions')
                ->withErrors($validator)
                ->withInput();
        }

        Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('permissions')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = \App\Models\Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if user has admin permissions
        if (!Auth::user()->hasRole('employee') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized access.');
        }

        $role = Role::findOrFail($id);

        // Prevent modification of the super_admin role
        if ($role->name === 'super_admin') {
            return redirect()->route('permissions')->with('error', 'The Super Admin role cannot be modified.');
        }

        // Prevent non-super_admins from modifying the admin role
        if ($role->name === 'employee' && !Auth::user()->hasRole('super_admin')) {
            return redirect()->route('permissions')->with('error', 'Only Super Admins can modify the Admin role.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('roles.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $role->update($request->only('name', 'description'));

        return redirect()->route('permissions')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if user has admin permissions
        if (!Auth::user()->hasRole('employee') && !Auth::user()->hasRole('owner')) {
            abort(403, 'Unauthorized access.');
        }

        $role = Role::findOrFail($id);
        
        // Prevent deletion of super_admin role
        if ($role->name === 'super_admin') {
            return redirect()->route('permissions')
                ->with('error', 'Cannot delete super admin role.');
        }
        
        // Prevent regular admin from deleting admin role if they're not super admin
        if ($role->name === 'employee' && !Auth::user()->isSuperAdmin()) {
            return redirect()->route('permissions')
                ->with('error', 'Only super admin can delete admin role.');
        }
        
        // Check if role has users assigned
        if ($role->users()->count() > 0) {
            return redirect()->route('permissions')
                ->with('error', 'Cannot delete role that has users assigned to it.');
        }

        $role->delete();

        return redirect()->route('permissions')
            ->with('success', 'Role deleted successfully.');
    }
}
