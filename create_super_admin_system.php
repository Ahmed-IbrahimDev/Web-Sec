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
    <title>Create Super Admin System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-crown me-2"></i>Create Super Admin System</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Creating Super Admin System...</div>";
                            
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
                                // Product permissions
                                ['name' => 'view_products', 'description' => 'Can view products'],
                                ['name' => 'create_products', 'description' => 'Can create products'],
                                ['name' => 'edit_products', 'description' => 'Can edit products'],
                                ['name' => 'delete_products', 'description' => 'Can delete products'],
                                
                                // User management permissions
                                ['name' => 'view_users', 'description' => 'Can view users'],
                                ['name' => 'create_users', 'description' => 'Can create users'],
                                ['name' => 'edit_users', 'description' => 'Can edit users'],
                                ['name' => 'delete_users', 'description' => 'Can delete users'],
                                ['name' => 'delete_admins', 'description' => 'Can delete admin users (Super Admin only)'],
                                
                                // Role and permission management
                                ['name' => 'view_roles', 'description' => 'Can view roles'],
                                ['name' => 'create_roles', 'description' => 'Can create roles'],
                                ['name' => 'edit_roles', 'description' => 'Can edit roles'],
                                ['name' => 'delete_roles', 'description' => 'Can delete roles'],
                                ['name' => 'manage_permissions', 'description' => 'Can manage permissions'],
                                
                                // System permissions
                                ['name' => 'access_dashboard', 'description' => 'Can access admin dashboard'],
                                ['name' => 'view_statistics', 'description' => 'Can view system statistics'],
                                ['name' => 'manage_system', 'description' => 'Can manage system settings (Super Admin only)'],
                            ];

                            foreach ($permissions as $permissionData) {
                                Permission::create($permissionData);
                            }
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Permissions created successfully!</div>";

                            // Step 3: Create roles
                            echo "<div class='alert alert-info'><i class='fas fa-user-tag me-2'></i>Creating roles...</div>";
                            
                            // Super Admin role
                            $AdminRole = Role::create([
                                'name' => 'admin',
                                'description' => 'Super Administrator with full system access',
                            ]);
                            
                            // Admin role
                            $adminRole = Role::create([
                                'name' => 'admin',
                                'description' => 'Administrator with product and user management access',
                            ]);
                            
                            // User role
                            $userRole = Role::create([
                                'name' => 'user',
                                'description' => 'Regular user with basic access - can only view catalog and purchase',
                            ]);
                            
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Roles created successfully!</div>";

                            // Step 4: Assign permissions to roles
                            echo "<div class='alert alert-info'><i class='fas fa-link me-2'></i>Assigning permissions to roles...</div>";
                            
                            // Super Admin gets ALL permissions
                            $superAdminRole->permissions()->attach(Permission::all());
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Super Admin: All permissions assigned</div>";
                            
                            // Admin gets most permissions but NOT delete_admins and manage_system
                            $adminPermissions = Permission::whereNotIn('name', ['delete_admins', 'manage_system'])->get();
                            $adminRole->permissions()->attach($adminPermissions);
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin: Limited permissions assigned</div>";
                            
                            // User role gets NO permissions - they can only access catalog (public routes)
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ User: No permissions assigned (catalog access only)</div>";

                            // Step 5: Create Super Admin user
                            echo "<div class='alert alert-info'><i class='fas fa-user-shield me-2'></i>Creating Super Admin user...</div>";
                            
                            // Delete any existing admin user
                            User::where('email', 'admin@example.com')->delete();
                            
                            // Create Super Admin user
                            $superAdmin = User::create([
                                'name' => 'Super Admin',
                                'email' => 'admin@example.com',
                                'password' => Hash::make('password'),
                            ]);
                            
                            // Assign Super Admin role
                            $superAdmin->roles()->sync([$superAdminRole->id]);
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Super Admin user created: admin@example.com / password</div>";

                            // Step 6: Create some sample admin users
                            echo "<div class='alert alert-info'><i class='fas fa-users me-2'></i>Creating sample admin users...</div>";
                            
                            $sampleAdmins = [
                                ['name' => 'Admin Manager', 'email' => 'manager@example.com', 'password' => 'password'],
                                ['name' => 'Product Admin', 'email' => 'product@example.com', 'password' => 'password'],
                            ];
                            
                            foreach ($sampleAdmins as $adminData) {
                                $admin = User::create([
                                    'name' => $adminData['name'],
                                    'email' => $adminData['email'],
                                    'password' => Hash::make($adminData['password']),
                                ]);
                                $admin->roles()->sync([$adminRole->id]);
                                echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Admin created: {$adminData['email']} / password</div>";
                            }

                            // Step 7: Handle existing regular users
                            echo "<div class='alert alert-info'><i class='fas fa-user me-2'></i>Setting up regular users...</div>";
                            $regularUsers = User::whereNotIn('email', ['admin@example.com', 'manager@example.com', 'product@example.com'])->get();
                            $userCount = 0;
                            foreach ($regularUsers as $user) {
                                $user->roles()->sync([$userRole->id]);
                                $userCount++;
                            }
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ User role assigned to {$userCount} regular users</div>";

                            // Step 8: Test the system
                            echo "<div class='alert alert-info'><i class='fas fa-vial me-2'></i>Testing the system...</div>";
                            
                            $superAdminTest = User::where('email', 'admin@example.com')->first();
                            $adminTest = User::where('email', 'manager@example.com')->first();
                            
                            echo "<div class='alert alert-info'>";
                            echo "<strong>Super Admin Test:</strong><br>";
                            echo "User: " . ($superAdminTest ? $superAdminTest->name : 'Not found') . "<br>";
                            echo "Has super_admin role: " . ($superAdminTest && $superAdminTest->hasRole('super_admin') ? 'YES' : 'NO') . "<br>";
                            echo "Can delete admins: " . ($superAdminTest && $superAdminTest->hasRole('super_admin') ? 'YES' : 'NO');
                            echo "</div>";
                            
                            echo "<div class='alert alert-info'>";
                            echo "<strong>Admin Test:</strong><br>";
                            echo "User: " . ($adminTest ? $adminTest->name : 'Not found') . "<br>";
                            echo "Has admin role: " . ($adminTest && $adminTest->hasRole('admin') ? 'YES' : 'NO') . "<br>";
                            echo "Can delete admins: " . ($adminTest && $adminTest->hasRole('super_admin') ? 'YES' : 'NO');
                            echo "</div>";

                            echo "<hr>";
                            
                            echo "<div class='alert alert-success'>";
                            echo "<h5><i class='fas fa-trophy me-2'></i>Super Admin System Created Successfully!</h5>";
                            echo "<div class='row'>";
                            echo "<div class='col-md-4'>";
                            echo "<h6><i class='fas fa-crown me-2'></i>Super Admin</h6>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Email:</strong> admin@example.com</li>";
                            echo "<li><strong>Password:</strong> password</li>";
                            echo "<li><strong>Permissions:</strong> ALL (including delete admins)</li>";
                            echo "</ul>";
                            echo "</div>";
                            echo "<div class='col-md-4'>";
                            echo "<h6><i class='fas fa-user-shield me-2'></i>Admins</h6>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Email:</strong> manager@example.com</li>";
                            echo "<li><strong>Password:</strong> password</li>";
                            echo "<li><strong>Permissions:</strong> Limited (no delete admins)</li>";
                            echo "</ul>";
                            echo "</div>";
                            echo "<div class='col-md-4'>";
                            echo "<h6><i class='fas fa-user me-2'></i>Regular Users</h6>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Permissions:</strong> Catalog only</li>";
                            echo "<li><strong>Access:</strong> View and purchase</li>";
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div class='alert alert-info'>";
                            echo "<h6><i class='fas fa-arrow-right me-2'></i>Next steps:</h6>";
                            echo "<ol class='mb-0'>";
                            echo "<li>Visit <a href='http://127.0.0.1:8000/login' target='_blank'>Login Page</a></li>";
                            echo "<li>Login as Super Admin: admin@example.com / password</li>";
                            echo "<li>Test admin users: manager@example.com / password</li>";
                            echo "<li>Register new regular user to test</li>";
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
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                            </a>
                            <a href="http://127.0.0.1:8000/permissions" class="btn btn-primary me-2">
                                <i class="fas fa-user-lock me-2"></i>View Permissions
                            </a>
                            <a href="http://127.0.0.1:8000/check_data.php" class="btn btn-info">
                                <i class="fas fa-database me-2"></i>Check Data
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