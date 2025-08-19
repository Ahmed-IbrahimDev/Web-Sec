<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Role Names</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-users-cog me-2"></i>Update Role Names</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Starting role name update process...</div>";
                            
                            // Start transaction
                            DB::beginTransaction();
                            
                            // Step 1: Rename existing 'admin' role to 'employee'
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 1: Renaming 'admin' to 'employee'</h5>";
                            $adminRole = Role::where('name', 'admin')->first();
                            if ($adminRole) {
                                $adminRole->name = 'employee';
                                $adminRole->description = 'Employee with system access and management capabilities';
                                $adminRole->save();
                                echo "<div class='alert alert-success'>✓ Successfully renamed 'admin' role to 'employee' (ID: {$adminRole->id})</div>";
                            } else {
                                echo "<div class='alert alert-warning'>⚠️ 'admin' role not found, creating new 'employee' role...</div>";
                                $adminRole = Role::create([
                                    'name' => 'employee',
                                    'description' => 'Employee with system access and management capabilities'
                                ]);
                                echo "<div class='alert alert-success'>✓ Created new 'employee' role (ID: {$adminRole->id})</div>";
                            }
                            
                            // Step 2: Rename existing 'customer' role to 'custmer'
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 2: Renaming 'customer' to 'custmer'</h5>";
                            $customerRole = Role::where('name', 'customer')->first();
                            if ($customerRole) {
                                $customerRole->name = 'custmer';
                                $customerRole->description = 'Custmer with access to view products and make purchases';
                                $customerRole->save();
                                echo "<div class='alert alert-success'>✓ Successfully renamed 'customer' role to 'custmer' (ID: {$customerRole->id})</div>";
                            } else {
                                echo "<div class='alert alert-warning'>⚠️ 'customer' role not found, creating new 'custmer' role...</div>";
                                $customerRole = Role::create([
                                    'name' => 'custmer',
                                    'description' => 'Custmer with access to view products and make purchases'
                                ]);
                                echo "<div class='alert alert-success'>✓ Created new 'custmer' role (ID: {$customerRole->id})</div>";
                            }
                            
                            // Step 3: Ensure 'user' role exists (keep as is)
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 3: Ensuring 'user' role exists</h5>";
                            $userRole = Role::where('name', 'user')->first();
                            if (!$userRole) {
                                $userRole = Role::create([
                                    'name' => 'user',
                                    'description' => 'Regular user with basic access'
                                ]);
                                echo "<div class='alert alert-success'>✓ Created 'user' role (ID: {$userRole->id})</div>";
                            } else {
                                echo "<div class='alert alert-info'>✓ 'user' role already exists (ID: {$userRole->id})</div>";
                            }
                            
                            // Step 4: Set up permissions for new roles
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 4: Setting up role permissions</h5>";
                            
                            // Get all permissions
                            $permissions = Permission::all();
                            echo "<div class='alert alert-info'>Found " . $permissions->count() . " permissions in system</div>";
                            
                            // Employee (formerly admin) gets all permissions
                            if ($permissions->count() > 0) {
                                $employeeRole = Role::where('name', 'employee')->first();
                                $employeeRole->permissions()->sync($permissions->pluck('id')->toArray());
                                echo "<div class='alert alert-success'>✓ Assigned all permissions to 'employee' role</div>";
                                
                                // Custmer gets limited permissions
                                $custmerPermissions = $permissions->whereIn('name', [
                                    'view_products', 
                                    'buy_products',
                                    'view_dashboard'
                                ])->pluck('id')->toArray();
                                
                                $custmerRole = Role::where('name', 'custmer')->first();
                                $custmerRole->permissions()->sync($custmerPermissions);
                                echo "<div class='alert alert-success'>✓ Assigned limited permissions to 'custmer' role</div>";
                                
                                // User gets basic permissions
                                $userPermissions = $permissions->whereIn('name', [
                                    'view_products',
                                    'buy_products'
                                ])->pluck('id')->toArray();
                                
                                $userRole->permissions()->sync($userPermissions);
                                echo "<div class='alert alert-success'>✓ Assigned basic permissions to 'user' role</div>";
                            }
                            
                            // Step 5: Update existing users with old roles
                            echo "<h5><i class='fas fa-arrow-right me-2'></i>Step 5: Updating existing user role assignments</h5>";
                            
                            // Find users and update their role assignments
                            $allUsers = User::with('roles')->get();
                            $updatedUsers = 0;
                            
                            foreach ($allUsers as $user) {
                                $hasOldAdmin = $user->roles->where('name', 'admin')->count() > 0;
                                $hasOldCustomer = $user->roles->where('name', 'customer')->count() > 0;
                                
                                if ($hasOldAdmin || $hasOldCustomer) {
                                    $newRoles = [];
                                    
                                    // Keep existing roles except old ones
                                    foreach ($user->roles as $role) {
                                        if (!in_array($role->name, ['admin', 'customer'])) {
                                            $newRoles[] = $role->id;
                                        }
                                    }
                                    
                                    // Add new equivalent roles
                                    if ($hasOldAdmin) {
                                        $newRoles[] = Role::where('name', 'employee')->first()->id;
                                    }
                                    if ($hasOldCustomer) {
                                        $newRoles[] = Role::where('name', 'custmer')->first()->id;
                                    }
                                    
                                    $user->roles()->sync($newRoles);
                                    $updatedUsers++;
                                }
                            }
                            
                            echo "<div class='alert alert-success'>✓ Updated {$updatedUsers} users with new role assignments</div>";
                            
                            // Commit transaction
                            DB::commit();
                            
                            // Step 6: Display summary
                            echo "<div class='alert alert-success mt-4'>";
                            echo "<h5><i class='fas fa-check-circle me-2'></i>Role Update Complete!</h5>";
                            echo "<h6>Current Roles:</h6>";
                            echo "<ul>";
                            
                            $currentRoles = Role::all();
                            foreach ($currentRoles as $role) {
                                $userCount = $role->users()->count();
                                $permissionCount = $role->permissions()->count();
                                echo "<li><strong>{$role->name}</strong>: {$role->description} ({$userCount} users, {$permissionCount} permissions)</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                            
                            // Test the new roles
                            echo "<h5><i class='fas fa-vial me-2'></i>Testing New Role System</h5>";
                            $testUser = User::with('roles')->first();
                            if ($testUser) {
                                echo "<div class='alert alert-info'>";
                                echo "<strong>Test User:</strong> {$testUser->name} ({$testUser->email})<br>";
                                echo "<strong>Roles:</strong> " . $testUser->roles->pluck('name')->implode(', ') . "<br>";
                                echo "<strong>Has employee role:</strong> " . ($testUser->hasRole('employee') ? 'YES' : 'NO') . "<br>";
                                echo "<strong>Has custmer role:</strong> " . ($testUser->hasRole('custmer') ? 'YES' : 'NO') . "<br>";
                                echo "<strong>Has user role:</strong> " . ($testUser->hasRole('user') ? 'YES' : 'NO');
                                echo "</div>";
                            }
                            
                        } catch (Exception $e) {
                            DB::rollBack();
                            echo "<div class='alert alert-danger'>";
                            echo "<h5><i class='fas fa-exclamation-triangle me-2'></i>Error occurred!</h5>";
                            echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
                            echo "<strong>File:</strong> " . $e->getFile() . "<br>";
                            echo "<strong>Line:</strong> " . $e->getLine() . "<br>";
                            echo "<strong>Trace:</strong><br><pre>" . $e->getTraceAsString() . "</pre>";
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
