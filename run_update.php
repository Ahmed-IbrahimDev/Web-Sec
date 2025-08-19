<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

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
    <title>Update Permissions System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-cogs me-2"></i>Update Permissions System</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Starting permissions system update...</div>";
                            
                            // Step 1: Clear existing roles and permissions
                            echo "<div class='alert alert-warning'><i class='fas fa-trash me-2'></i>Clearing existing roles and permissions...</div>";
                            \DB::table('permission_role')->truncate();
                            \DB::table('role_user')->truncate();
                            Role::truncate();
                            Permission::truncate();
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Cleared successfully!</div>";
                            
                            // Step 2: Create permissions
                            echo "<div class='alert alert-info'><i class='fas fa-plus me-2'></i>Creating permissions...</div>";
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
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Permissions created successfully!</div>";

                            // Step 3: Create roles
                            echo "<div class='alert alert-info'><i class='fas fa-user-tag me-2'></i>Creating roles...</div>";
                            $adminRole = Role::create([
                                'name' => 'admin',
                                'description' => 'Administrator with full access',
                            ]);

                            $userRole = Role::create([
                                'name' => 'user',
                                'description' => 'Regular user with basic access - can only view catalog and purchase',
                            ]);
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Roles created successfully!</div>";

                            // Step 4: Assign permissions to roles
                            echo "<div class='alert alert-info'><i class='fas fa-link me-2'></i>Assigning permissions to roles...</div>";
                            $adminRole->permissions()->attach(Permission::all());
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin role: All permissions assigned</div>";
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ User role: No permissions assigned (catalog access only)</div>";

                            // Step 5: Handle admin user
                            echo "<div class='alert alert-info'><i class='fas fa-user-shield me-2'></i>Setting up admin user...</div>";
                            $adminUser = User::where('email', 'admin@example.com')->first();
                            if (!$adminUser) {
                                $adminUser = User::create([
                                    'name' => 'Admin User',
                                    'email' => 'admin@example.com',
                                    'password' => Hash::make('password'),
                                ]);
                                echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin user created</div>";
                            } else {
                                echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin user already exists</div>";
                            }

                            $adminUser->roles()->sync([$adminRole->id]);
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin role assigned to admin user</div>";

                            // Step 6: Handle regular users
                            echo "<div class='alert alert-info'><i class='fas fa-users me-2'></i>Setting up regular users...</div>";
                            $regularUsers = User::where('email', '!=', 'admin@example.com')->get();
                            $userCount = 0;
                            foreach ($regularUsers as $user) {
                                $user->roles()->sync([$userRole->id]);
                                $userCount++;
                            }
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ User role assigned to {$userCount} regular users</div>";

                            // Step 7: Test the system
                            echo "<div class='alert alert-info'><i class='fas fa-vial me-2'></i>Testing the system...</div>";
                            $adminTest = User::where('email', 'admin@example.com')->first();
                            $regularUsersTest = User::where('email', '!=', 'admin@example.com')->get();
                            
                            echo "<div class='alert alert-info'>";
                            echo "<strong>Admin user:</strong> " . ($adminTest ? $adminTest->name : 'Not found') . "<br>";
                            echo "<strong>Admin has admin role:</strong> " . ($adminTest && $adminTest->hasRole('admin') ? 'YES' : 'NO') . "<br>";
                            echo "<strong>Regular users count:</strong> " . $regularUsersTest->count();
                            echo "</div>";
                            
                            foreach ($regularUsersTest as $user) {
                                echo "<div class='alert alert-light'>";
                                echo "<strong>{$user->name}</strong> ({$user->email}): " . ($user->hasRole('user') ? 'User role' : 'No role');
                                echo "</div>";
                            }

                            echo "<div class='alert alert-success'>";
                            echo "<h5><i class='fas fa-trophy me-2'></i>PERMISSIONS SYSTEM UPDATED SUCCESSFULLY!</h5>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Admin user:</strong> admin@example.com / password</li>";
                            echo "<li><strong>Admin has full access</strong> to all features</li>";
                            echo "<li><strong>Regular users</strong> can only access catalog and purchase</li>";
                            echo "<li><strong>All existing users</strong> have been assigned appropriate roles</li>";
                            echo "</ul>";
                            echo "</div>";
                            
                            echo "<div class='alert alert-info'>";
                            echo "<h6><i class='fas fa-arrow-right me-2'></i>Next steps:</h6>";
                            echo "<ol class='mb-0'>";
                            echo "<li>Visit <a href='http://127.0.0.1:8000' target='_blank'>http://127.0.0.1:8000</a></li>";
                            echo "<li>Login as admin: admin@example.com / password</li>";
                            echo "<li>Test regular user by registering a new account</li>";
                            echo "<li>Verify that regular users can only see catalog</li>";
                            echo "</ol>";
                            echo "</div>";
                            
                        } catch (Exception $e) {
                            echo "<div class='alert alert-danger'>";
                            echo "<h5><i class='fas fa-exclamation-triangle me-2'></i>Error occurred!</h5>";
                            echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
                            echo "<strong>File:</strong> " . $e->getFile() . "<br>";
                            echo "<strong>Line:</strong> " . $e->getLine();
                            echo "</div>";
                        }
                        ?>
                        
                        <div class="text-center mt-4">
                            <a href="http://127.0.0.1:8000" class="btn btn-primary me-2">
                                <i class="fas fa-home me-2"></i>Go to Application
                            </a>
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Login as Admin
                            </a>
                            <a href="http://127.0.0.1:8000/register" class="btn btn-info">
                                <i class="fas fa-user-plus me-2"></i>Register New User
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