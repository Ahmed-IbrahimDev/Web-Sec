<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database and Update Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-database me-2"></i>Setup Database and Update Roles</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Starting database setup and role update process...</div>";
                            
                            // Start transaction
                            DB::beginTransaction();
                            
                            // Step 1: Create role_user table if it doesn't exist
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 1: Setting up pivot tables</h5>";
                            
                            if (!Schema::hasTable('role_user')) {
                                DB::statement('
                                    CREATE TABLE role_user (
                                        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                        user_id BIGINT UNSIGNED NOT NULL,
                                        role_id BIGINT UNSIGNED NOT NULL,
                                        created_at TIMESTAMP NULL DEFAULT NULL,
                                        updated_at TIMESTAMP NULL DEFAULT NULL,
                                        UNIQUE KEY role_user_user_id_role_id_unique (user_id, role_id),
                                        KEY role_user_user_id_index (user_id),
                                        KEY role_user_role_id_index (role_id)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                                ');
                                echo "<div class='alert alert-success'>✓ Created role_user pivot table</div>";
                            } else {
                                echo "<div class='alert alert-info'>✓ role_user table already exists</div>";
                            }
                            
                            if (!Schema::hasTable('permission_role')) {
                                DB::statement('
                                    CREATE TABLE permission_role (
                                        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                        permission_id BIGINT UNSIGNED NOT NULL,
                                        role_id BIGINT UNSIGNED NOT NULL,
                                        created_at TIMESTAMP NULL DEFAULT NULL,
                                        updated_at TIMESTAMP NULL DEFAULT NULL,
                                        UNIQUE KEY permission_role_permission_id_role_id_unique (permission_id, role_id),
                                        KEY permission_role_permission_id_index (permission_id),
                                        KEY permission_role_role_id_index (role_id)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                                ');
                                echo "<div class='alert alert-success'>✓ Created permission_role pivot table</div>";
                            } else {
                                echo "<div class='alert alert-info'>✓ permission_role table already exists</div>";
                            }
                            
                            // Step 2: Create basic permissions
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 2: Setting up permissions</h5>";
                            
                            $permissions = [
                                ['name' => 'view_products', 'description' => 'View products'],
                                ['name' => 'create_products', 'description' => 'Create new products'],
                                ['name' => 'edit_products', 'description' => 'Edit existing products'],
                                ['name' => 'delete_products', 'description' => 'Delete products'],
                                ['name' => 'view_dashboard', 'description' => 'View dashboard'],
                                ['name' => 'buy_products', 'description' => 'Purchase products'],
                                ['name' => 'manage_users', 'description' => 'Manage users'],
                                ['name' => 'manage_roles', 'description' => 'Manage roles and permissions'],
                            ];
                            
                            foreach ($permissions as $permissionData) {
                                Permission::firstOrCreate(
                                    ['name' => $permissionData['name']], 
                                    ['description' => $permissionData['description']]
                                );
                            }
                            echo "<div class='alert alert-success'>✓ Created " . count($permissions) . " permissions</div>";
                            
                            // Step 3: Create/Update roles with new names
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 3: Creating/Updating roles</h5>";
                            
                            // Remove old admin role if exists and create employee role
                            $oldAdminRole = Role::where('name', 'admin')->first();
                            if ($oldAdminRole) {
                                // Get users with admin role
                                $adminUsers = $oldAdminRole->users;
                                
                                // Create employee role
                                $employeeRole = Role::firstOrCreate(
                                    ['name' => 'employee'], 
                                    ['description' => 'Employee with system access and management capabilities']
                                );
                                
                                // Transfer users from admin to employee role
                                foreach ($adminUsers as $user) {
                                    $user->roles()->detach($oldAdminRole->id);
                                    $user->roles()->attach($employeeRole->id);
                                }
                                
                                // Delete old admin role
                                $oldAdminRole->delete();
                                echo "<div class='alert alert-success'>✓ Renamed 'admin' role to 'employee' and transferred " . count($adminUsers) . " users</div>";
                            } else {
                                $employeeRole = Role::firstOrCreate(
                                    ['name' => 'employee'], 
                                    ['description' => 'Employee with system access and management capabilities']
                                );
                                echo "<div class='alert alert-success'>✓ Created new 'employee' role</div>";
                            }
                            
                            // Remove old customer role if exists and create custmer role
                            $oldCustomerRole = Role::where('name', 'customer')->first();
                            if ($oldCustomerRole) {
                                // Get users with customer role
                                $customerUsers = $oldCustomerRole->users;
                                
                                // Create custmer role
                                $custmerRole = Role::firstOrCreate(
                                    ['name' => 'custmer'], 
                                    ['description' => 'Custmer with access to view products and make purchases']
                                );
                                
                                // Transfer users from customer to custmer role
                                foreach ($customerUsers as $user) {
                                    $user->roles()->detach($oldCustomerRole->id);
                                    $user->roles()->attach($custmerRole->id);
                                }
                                
                                // Delete old customer role
                                $oldCustomerRole->delete();
                                echo "<div class='alert alert-success'>✓ Renamed 'customer' role to 'custmer' and transferred " . count($customerUsers) . " users</div>";
                            } else {
                                $custmerRole = Role::firstOrCreate(
                                    ['name' => 'custmer'], 
                                    ['description' => 'Custmer with access to view products and make purchases']
                                );
                                echo "<div class='alert alert-success'>✓ Created new 'custmer' role</div>";
                            }
                            
                            // Create other essential roles
                            $userRole = Role::firstOrCreate(
                                ['name' => 'user'], 
                                ['description' => 'Regular user with basic access']
                            );
                            
                            $superAdminRole = Role::firstOrCreate(
                                ['name' => 'super_admin'], 
                                ['description' => 'Super administrator with full system access']
                            );
                            
                            $ownerRole = Role::firstOrCreate(
                                ['name' => 'owner'], 
                                ['description' => 'System owner with complete control']
                            );
                            
                            echo "<div class='alert alert-success'>✓ Ensured all essential roles exist</div>";
                            
                            // Step 4: Assign permissions to roles
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 4: Assigning permissions to roles</h5>";
                            
                            $allPermissions = Permission::all();
                            
                            // Employee gets most permissions (formerly admin)
                            $employeePermissions = $allPermissions->whereIn('name', [
                                'view_products', 'create_products', 'edit_products', 'delete_products', 
                                'view_dashboard', 'buy_products', 'manage_users'
                            ]);
                            $employeeRole->permissions()->sync($employeePermissions->pluck('id')->toArray());
                            
                            // Custmer gets limited permissions
                            $custmerPermissions = $allPermissions->whereIn('name', [
                                'view_products', 'buy_products', 'view_dashboard'
                            ]);
                            $custmerRole->permissions()->sync($custmerPermissions->pluck('id')->toArray());
                            
                            // User gets basic permissions
                            $userPermissions = $allPermissions->whereIn('name', [
                                'view_products', 'buy_products'
                            ]);
                            $userRole->permissions()->sync($userPermissions->pluck('id')->toArray());
                            
                            // Super admin and owner get all permissions
                            $superAdminRole->permissions()->sync($allPermissions->pluck('id')->toArray());
                            $ownerRole->permissions()->sync($allPermissions->pluck('id')->toArray());
                            
                            echo "<div class='alert alert-success'>✓ Assigned permissions to all roles</div>";
                            
                            // Step 5: Create a test employee user if none exists
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 5: Creating test employee user</h5>";
                            
                            $employeeUser = User::where('email', 'employee@example.com')->first();
                            if (!$employeeUser) {
                                $employeeUser = User::create([
                                    'name' => 'Employee User',
                                    'email' => 'employee@example.com',
                                    'password' => Hash::make('password'),
                                ]);
                                $employeeUser->roles()->attach($employeeRole->id);
                                echo "<div class='alert alert-success'>✓ Created test employee user (employee@example.com / password)</div>";
                            } else {
                                // Ensure the existing user has employee role
                                if (!$employeeUser->hasRole('employee')) {
                                    $employeeUser->roles()->attach($employeeRole->id);
                                }
                                echo "<div class='alert alert-info'>✓ Employee user already exists, ensured employee role</div>";
                            }
                            
                            // Create a test custmer user if none exists
                            $custmerUser = User::where('email', 'custmer@example.com')->first();
                            if (!$custmerUser) {
                                $custmerUser = User::create([
                                    'name' => 'Custmer User',
                                    'email' => 'custmer@example.com',
                                    'password' => Hash::make('password'),
                                ]);
                                $custmerUser->roles()->attach($custmerRole->id);
                                echo "<div class='alert alert-success'>✓ Created test custmer user (custmer@example.com / password)</div>";
                            } else {
                                // Ensure the existing user has custmer role
                                if (!$custmerUser->hasRole('custmer')) {
                                    $custmerUser->roles()->attach($custmerRole->id);
                                }
                                echo "<div class='alert alert-info'>✓ Custmer user already exists, ensured custmer role</div>";
                            }
                            
                            // Commit transaction
                            DB::commit();
                            
                            // Step 6: Display summary
                            echo "<div class='alert alert-success mt-4'>";
                            echo "<h5><i class='fas fa-check-circle me-2'></i>Database Setup and Role Update Complete!</h5>";
                            echo "<h6>Current Roles:</h6>";
                            echo "<ul>";
                            
                            $currentRoles = Role::with(['users', 'permissions'])->get();
                            foreach ($currentRoles as $role) {
                                $userCount = $role->users->count();
                                $permissionCount = $role->permissions->count();
                                echo "<li><strong>{$role->name}</strong>: {$role->description} ({$userCount} users, {$permissionCount} permissions)</li>";
                            }
                            echo "</ul>";
                            
                            echo "<h6>Test Users Created:</h6>";
                            echo "<ul>";
                            echo "<li><strong>Employee:</strong> employee@example.com / password</li>";
                            echo "<li><strong>Custmer:</strong> custmer@example.com / password</li>";
                            echo "</ul>";
                            echo "</div>";
                            
                            // Test the new roles
                            echo "<h5><i class='fas fa-vial me-2'></i>Testing New Role System</h5>";
                            $testEmployee = User::where('email', 'employee@example.com')->first();
                            $testCustmer = User::where('email', 'custmer@example.com')->first();
                            
                            if ($testEmployee) {
                                echo "<div class='alert alert-info'>";
                                echo "<strong>Employee Test User:</strong> {$testEmployee->name}<br>";
                                echo "<strong>Has employee role:</strong> " . ($testEmployee->hasRole('employee') ? 'YES' : 'NO') . "<br>";
                                echo "<strong>Can manage users:</strong> " . ($testEmployee->hasPermission('manage_users') ? 'YES' : 'NO');
                                echo "</div>";
                            }
                            
                            if ($testCustmer) {
                                echo "<div class='alert alert-info'>";
                                echo "<strong>Custmer Test User:</strong> {$testCustmer->name}<br>";
                                echo "<strong>Has custmer role:</strong> " . ($testCustmer->hasRole('custmer') ? 'YES' : 'NO') . "<br>";
                                echo "<strong>Can buy products:</strong> " . ($testCustmer->hasPermission('buy_products') ? 'YES' : 'NO');
                                echo "</div>";
                            }
                            
                        } catch (Exception $e) {
                            DB::rollBack();
                            echo "<div class='alert alert-danger'>";
                            echo "<h5><i class='fas fa-exclamation-triangle me-2'></i>Error occurred!</h5>";
                            echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
                            echo "<strong>File:</strong> " . $e->getFile() . "<br>";
                            echo "<strong>Line:</strong> " . $e->getLine();
                            echo "</div>";
                        }
                        ?>
                        
                        <div class="mt-4">
                            <a href="check_data.php" class="btn btn-info me-2">
                                <i class="fas fa-search me-1"></i>Check Data
                            </a>
                            <a href="test_permissions.php" class="btn btn-success me-2">
                                <i class="fas fa-vial me-1"></i>Test Permissions
                            </a>
                            <a href="/" class="btn btn-primary">
                                <i class="fas fa-home me-1"></i>Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
