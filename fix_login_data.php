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
    <title>Fix Login Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Fix Login Data</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-search me-2'></i>Searching for problematic users...</div>";
                            
                            // Find users with problematic email
                            $problematicUsers = User::where('email', 'like', '%image.png%')->get();
                            
                            if ($problematicUsers->count() > 0) {
                                echo "<div class='alert alert-warning'>";
                                echo "<strong>Found {$problematicUsers->count()} problematic user(s):</strong><br>";
                                foreach ($problematicUsers as $user) {
                                    echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}<br>";
                                }
                                echo "</div>";
                                
                                // Delete problematic users
                                foreach ($problematicUsers as $user) {
                                    $user->delete();
                                }
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ Deleted {$problematicUsers->count()} problematic user(s)</strong>";
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ No problematic users found</strong>";
                                echo "</div>";
                            }
                            
                            echo "<hr>";
                            
                            // Check for correct admin user
                            $adminUser = User::where('email', 'admin@example.com')->first();
                            
                            if ($adminUser) {
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ Correct admin user found:</strong><br>";
                                echo "ID: {$adminUser->id}<br>";
                                echo "Name: {$adminUser->name}<br>";
                                echo "Email: {$adminUser->email}<br>";
                                echo "Created: {$adminUser->created_at}";
                                echo "</div>";
                                
                                // Check admin role
                                $adminRole = Role::where('name', 'admin')->first();
                                if ($adminRole) {
                                    $adminUser->roles()->sync([$adminRole->id]);
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>✓ Admin role assigned to admin user</strong>";
                                    echo "</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<strong>❌ Admin role not found!</strong><br>";
                                    echo "Please run the full update script.";
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
                                echo "<strong>✓ Admin user created:</strong><br>";
                                echo "ID: {$adminUser->id}<br>";
                                echo "Name: {$adminUser->name}<br>";
                                echo "Email: {$adminUser->email}";
                                echo "</div>";
                                
                                // Check admin role
                                $adminRole = Role::where('name', 'admin')->first();
                                if ($adminRole) {
                                    $adminUser->roles()->sync([$adminRole->id]);
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>✓ Admin role assigned to admin user</strong>";
                                    echo "</div>";
                                }
                            }
                            
                            echo "<hr>";
                            
                            // Show all users
                            echo "<h5><i class='fas fa-users me-2'></i>All Users:</h5>";
                            $allUsers = User::all();
                            if ($allUsers->count() > 0) {
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-striped'>";
                                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Roles</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($allUsers as $user) {
                                    $roles = $user->roles->pluck('name')->join(', ');
                                    echo "<tr>";
                                    echo "<td>{$user->id}</td>";
                                    echo "<td>{$user->name}</td>";
                                    echo "<td>{$user->email}</td>";
                                    echo "<td>" . ($roles ? $roles : 'No roles') . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            } else {
                                echo "<div class='alert alert-warning'>No users found</div>";
                            }
                            
                            echo "<hr>";
                            
                            echo "<div class='alert alert-success'>";
                            echo "<h5><i class='fas fa-check-circle me-2'></i>Login Data Fixed!</h5>";
                            echo "<ul class='mb-0'>";
                            echo "<li><strong>Email:</strong> admin@example.com</li>";
                            echo "<li><strong>Password:</strong> password</li>";
                            echo "<li><strong>Role:</strong> admin</li>";
                            echo "<li><strong>Status:</strong> Ready to login</li>";
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
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Test Login
                            </a>
                            <a href="http://127.0.0.1:8000/run_update.php" class="btn btn-primary me-2">
                                <i class="fas fa-cogs me-2"></i>Run Full Update
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