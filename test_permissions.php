<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

try {
    echo "=== TESTING PERMISSIONS SYSTEM ===\n\n";
    
    // Test 1: Check roles
    echo "1. Testing Roles:\n";
    $roles = Role::all();
    foreach ($roles as $role) {
        echo "   - Role: {$role->name} ({$role->description})\n";
        $permissions = $role->permissions;
        if ($permissions->count() > 0) {
            echo "     Permissions: ";
            foreach ($permissions as $permission) {
                echo "{$permission->name} ";
            }
            echo "\n";
        } else {
            echo "     Permissions: None\n";
        }
    }
    echo "\n";
    
    // Test 2: Check users and their roles
    echo "2. Testing Users and Roles:\n";
    $users = User::with('roles')->get();
    foreach ($users as $user) {
        echo "   - User: {$user->name} ({$user->email})\n";
        $roles = $user->roles;
        if ($roles->count() > 0) {
            echo "     Roles: ";
            foreach ($roles as $role) {
                echo "{$role->name} ";
            }
            echo "\n";
        } else {
            echo "     Roles: None\n";
        }
    }
    echo "\n";
    
    // Test 3: Check permissions
    echo "3. Testing Permissions:\n";
    $permissions = Permission::all();
    foreach ($permissions as $permission) {
        echo "   - Permission: {$permission->name} ({$permission->description})\n";
    }
    echo "\n";
    
    // Test 4: Test admin user
    echo "4. Testing Admin User:\n";
    $adminUser = User::where('email', 'admin@example.com')->first();
    if ($adminUser) {
        echo "   - Admin user exists: {$adminUser->name}\n";
        echo "   - Has admin role: " . ($adminUser->hasRole('admin') ? 'YES' : 'NO') . "\n";
    } else {
        echo "   - Admin user not found!\n";
    }
    echo "\n";
    
    // Test 5: Test regular users
    echo "5. Testing Regular Users:\n";
    $regularUsers = User::where('email', '!=', 'admin@example.com')->get();
    foreach ($regularUsers as $user) {
        echo "   - User: {$user->name} ({$user->email})\n";
        echo "     Has admin role: " . ($user->hasRole('admin') ? 'YES' : 'NO') . "\n";
        echo "     Has user role: " . ($user->hasRole('user') ? 'YES' : 'NO') . "\n";
    }
    echo "\n";
    
    echo "=== PERMISSIONS SYSTEM TEST COMPLETED ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 