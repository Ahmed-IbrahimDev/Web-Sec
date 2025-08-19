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
    <title>Fix Admin User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-tools me-2"></i>Fix Admin User</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Checking current admin user...</div>";
                            
                            // Check if admin user exists
                            $adminUser = User::where('email', 'admin@example.com')->first();
                            
                            if ($adminUser) {
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ Admin user found:</strong> {$adminUser->name} ({$adminUser->email})<br>";
                                echo "<strong>ID:</strong> {$adminUser->id}<br>";
                                echo "<strong>Created:</strong> {$adminUser->created_at}";
                                echo "</div>";
                                
                                // Check if admin role exists
                                $adminRole = Role::where('name', 'admin')->first();
                                if ($adminRole) {
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>✓ Admin role found:</strong> {$adminRole->name}<br>";
                                    echo "<strong>ID:</strong> {$adminRole->id}";
                                    echo "</div>";
                                    
                                    // Assign admin role to admin user
                                    $adminUser->roles()->sync([$adminRole->id]);
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>✓ Admin role assigned to admin user!</strong>";
                                    echo "</div>";
                                    
                                    // Test the assignment
                                    echo "<div class='alert alert-info'>";
                                    echo "<strong>Testing admin user:</strong><br>";
                                    echo "Has admin role: " . ($adminUser->hasRole('admin') ? 'YES' : 'NO') . "<br>";
                                    echo "Has user role: " . ($adminUser->hasRole('user') ? 'YES' : 'NO');
                                    echo "</div>";
                                    
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<strong>❌ Admin role not found!</strong><br>";
                                    echo "Please run the update script first.";
                                    echo "</div>";
                                }
                                
                            } else {
                                echo "<div class='alert alert-warning'>";
                                echo "<strong>⚠️ Admin user not found!</strong><br>";
                                echo "Creating new admin user...";
                                echo "</div>";
                                
                                // Create admin user
                                $adminUser = User::create([
                                    'name' => 'Admin User',
                                    'email' => 'admin@example.com',
                                    'password' => Hash::make('password'),
                                ]);
                                
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ Admin user created:</strong> {$adminUser->name} ({$adminUser->email})<br>";
                                echo "<strong>ID:</strong> {$adminUser->id}";
                                echo "</div>";
                                
                                // Check if admin role exists
                                $adminRole = Role::where('name', 'admin')->first();
                                if ($adminRole) {
                                    $adminUser->roles()->sync([$adminRole->id]);
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>✓ Admin role assigned to admin user!</strong>";
                                    echo "</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<strong>❌ Admin role not found!</strong><br>";
                                    echo "Please run the update script first.";
                                    echo "</div>";
                                }
                            }
                            
                            echo "<hr>";
                            
                            echo "<div class='alert alert-success'>";
                            echo "<h5><i class='fas fa-check-circle me-2'></i>Admin User Setup Complete!</h5>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Email:</strong> admin@example.com</li>";
                            echo "<li><strong>Password:</strong> password</li>";
                            echo "<li><strong>Role:</strong> admin (with all permissions)</li>";
                            echo "</ul>";
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
                            <a href="http://127.0.0.1:8000/run_update.php" class="btn btn-primary me-2">
                                <i class="fas fa-cogs me-2"></i>Run Full Update
                            </a>
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Test Login
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