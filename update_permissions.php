<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== UPDATING PERMISSIONS SYSTEM ===\n\n";
    
    // Step 1: Clear existing roles and permissions
    echo "1. Clearing existing roles and permissions...\n";
    \DB::table('permission_role')->truncate();
    \DB::table('role_user')->truncate();
    Role::truncate();
    Permission::truncate();
    echo "✓ Cleared successfully!\n\n";
    
    // Step 2: Create permissions
    echo "2. Creating permissions...\n";
    $permissions = [
        ['name' => 'view_products', 'description' => 'Can view products'],
        ['name' => 'create_products', 'description' => 'Can create products'],
        ['name' => 'edit_products', 'description' => 'Can edit products'],
        ['name' => 'delete_products', 'description' => 'Can delete products'],
        ['name' => 'view_users', 'description' => 'Can view users'],
        ['name' => 'manage_users', 'description' => 'Can manage users'],
        ['name' => 'manage_roles', 'description' => 'Can manage roles and permissions'],
    ];

    foreach ($permissions as $permissionData) {
        Permission::create($permissionData);
    }
    echo "✓ Permissions created successfully!\n\n";

    // Step 3: Create roles
    echo "3. Creating roles...\n";
    $adminRole = Role::create([
        'name' => 'admin',
        'description' => 'Administrator with full access',
    ]);

    $userRole = Role::create([
        'name' => 'user',
        'description' => 'Regular user with basic access - can only view catalog and purchase',
    ]);
    echo "✓ Roles created successfully!\n\n";

    // Step 4: Assign permissions to roles
    echo "4. Assigning permissions to roles...\n";
    // Admin gets all permissions
    $adminRole->permissions()->attach(Permission::all());
    echo "✓ Admin role: All permissions assigned\n";
    
    // User role gets NO permissions - they can only access catalog (public routes)
    echo "✓ User role: No permissions assigned (catalog access only)\n\n";

    // Step 5: Handle admin user
    echo "5. Setting up admin user...\n";
    $adminUser = User::where('email', 'admin@example.com')->first();
    if (!$adminUser) {
        echo "Creating admin user...\n";
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        echo "✓ Admin user created\n";
    } else {
        echo "✓ Admin user already exists\n";
    }

    // Assign admin role to admin user
    $adminUser->roles()->sync([$adminRole->id]);
    echo "✓ Admin role assigned to admin user\n\n";

    // Step 6: Handle regular users
    echo "6. Setting up regular users...\n";
    $regularUsers = User::where('email', '!=', 'admin@example.com')->get();
    $userCount = 0;
    foreach ($regularUsers as $user) {
        $user->roles()->sync([$userRole->id]);
        $userCount++;
    }
    echo "✓ User role assigned to {$userCount} regular users\n\n";

    // Step 7: Test the system
    echo "7. Testing the system...\n";
    $adminTest = User::where('email', 'admin@example.com')->first();
    $regularUsersTest = User::where('email', '!=', 'admin@example.com')->get();
    
    echo "Admin user: " . ($adminTest ? $adminTest->name : 'Not found') . "\n";
    echo "Admin has admin role: " . ($adminTest && $adminTest->hasRole('admin') ? 'YES' : 'NO') . "\n";
    echo "Regular users count: " . $regularUsersTest->count() . "\n";
    
    foreach ($regularUsersTest as $user) {
        echo "- {$user->name} ({$user->email}): " . ($user->hasRole('user') ? 'User role' : 'No role') . "\n";
    }
    echo "\n";

    echo "=== PERMISSIONS SYSTEM UPDATED SUCCESSFULLY ===\n";
    echo "🎯 Admin user: admin@example.com / password\n";
    echo "🎯 Admin has full access to all features\n";
    echo "🎯 Regular users can only access catalog and purchase\n";
    echo "🎯 All existing users have been assigned appropriate roles\n";
    echo "===============================================\n";
    
    echo "\n📝 Next steps:\n";
    echo "1. Visit http://127.0.0.1:8000\n";
    echo "2. Login as admin: admin@example.com / password\n";
    echo "3. Test regular user by registering a new account\n";
    echo "4. Verify that regular users can only see catalog\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 