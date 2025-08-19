<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Setting up Roles and Permissions System...\n";

try {
    // Create roles if they don't exist
    $roles = [
        ['name' => 'super_admin', 'description' => 'Super Administrator with full system access'],
        ['name' => 'admin', 'description' => 'Administrator with limited system access'],
        ['name' => 'manager', 'description' => 'Manager with product management access'],
        ['name' => 'user', 'description' => 'Regular user with basic access']
    ];

    foreach ($roles as $roleData) {
        $role = Role::firstOrCreate(
            ['name' => $roleData['name']],
            ['description' => $roleData['description']]
        );
        echo "✓ Role '{$role->name}' created/exists\n";
    }

    // Create permissions if they don't exist
    $permissions = [
        ['name' => 'view_products', 'description' => 'View products in catalog'],
        ['name' => 'create_products', 'description' => 'Create new products'],
        ['name' => 'edit_products', 'description' => 'Edit existing products'],
        ['name' => 'delete_products', 'description' => 'Delete products'],
        ['name' => 'manage_users', 'description' => 'Manage user accounts'],
        ['name' => 'manage_roles', 'description' => 'Manage roles and permissions'],
        ['name' => 'view_dashboard', 'description' => 'Access dashboard'],
        ['name' => 'buy_products', 'description' => 'Purchase products']
    ];

    foreach ($permissions as $permissionData) {
        $permission = Permission::firstOrCreate(
            ['name' => $permissionData['name']],
            ['description' => $permissionData['description']]
        );
        echo "✓ Permission '{$permission->name}' created/exists\n";
    }

    // Assign permissions to roles
    $rolePermissions = [
        'super_admin' => ['view_products', 'create_products', 'edit_products', 'delete_products', 'manage_users', 'manage_roles', 'view_dashboard', 'buy_products'],
        'admin' => ['view_products', 'create_products', 'edit_products', 'delete_products', 'view_dashboard', 'buy_products'],
        'manager' => ['view_products', 'create_products', 'edit_products', 'view_dashboard', 'buy_products'],
        'user' => ['view_products', 'buy_products', 'view_dashboard']
    ];

    foreach ($rolePermissions as $roleName => $permissionNames) {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $permissions = Permission::whereIn('name', $permissionNames)->get();
            $role->permissions()->sync($permissions->pluck('id'));
            echo "✓ Assigned permissions to role '{$roleName}'\n";
        }
    }

    // Assign super_admin role to user ID 1
    $user1 = User::find(1);
    if ($user1) {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $user1->roles()->sync([$superAdminRole->id]);
            echo "✓ Assigned super_admin role to user ID 1 ({$user1->name})\n";
        }
    } else {
        echo "⚠ User with ID 1 not found\n";
    }

    // Assign admin role to user ID 2
    $user2 = User::find(2);
    if ($user2) {
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user2->roles()->sync([$adminRole->id]);
            echo "✓ Assigned admin role to user ID 2 ({$user2->name})\n";
        }
    } else {
        echo "⚠ User with ID 2 not found\n";
    }

    // Assign user role to remaining users
    $remainingUsers = User::whereNotIn('id', [1, 2])->get();
    $userRole = Role::where('name', 'user')->first();
    
    if ($userRole) {
        foreach ($remainingUsers as $user) {
            if ($user->roles()->count() == 0) {
                $user->roles()->sync([$userRole->id]);
                echo "✓ Assigned user role to user ID {$user->id} ({$user->name})\n";
            }
        }
    }

    echo "\n✅ Roles and Permissions setup completed successfully!\n";
    echo "\nRole Summary:\n";
    echo "- Super Admin (User ID 1): Full system access\n";
    echo "- Admin (User ID 2): Product management + basic admin\n";
    echo "- Regular Users: View and buy products only\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
