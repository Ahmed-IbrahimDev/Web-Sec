<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Database Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-database me-2"></i>Database Data Check</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<h5><i class='fas fa-users me-2'></i>Users:</h5>";
                            $users = User::all();
                            if ($users->count() > 0) {
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-striped'>";
                                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th><th>Roles</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($users as $user) {
                                    $roles = $user->roles->pluck('name')->join(', ');
                                    echo "<tr>";
                                    echo "<td>{$user->id}</td>";
                                    echo "<td>{$user->name}</td>";
                                    echo "<td>{$user->email}</td>";
                                    echo "<td>{$user->created_at}</td>";
                                    echo "<td>" . ($roles ? $roles : 'No roles') . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            } else {
                                echo "<div class='alert alert-warning'>No users found</div>";
                            }

                            echo "<hr>";

                            echo "<h5><i class='fas fa-user-tag me-2'></i>Roles:</h5>";
                            $roles = Role::all();
                            if ($roles->count() > 0) {
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-striped'>";
                                echo "<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Permissions</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($roles as $role) {
                                    $permissions = $role->permissions->pluck('name')->join(', ');
                                    echo "<tr>";
                                    echo "<td>{$role->id}</td>";
                                    echo "<td>{$role->name}</td>";
                                    echo "<td>{$role->description}</td>";
                                    echo "<td>" . ($permissions ? $permissions : 'No permissions') . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            } else {
                                echo "<div class='alert alert-warning'>No roles found</div>";
                            }

                            echo "<hr>";

                            echo "<h5><i class='fas fa-key me-2'></i>Permissions:</h5>";
                            $permissions = Permission::all();
                            if ($permissions->count() > 0) {
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-striped'>";
                                echo "<thead><tr><th>ID</th><th>Name</th><th>Description</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($permissions as $permission) {
                                    echo "<tr>";
                                    echo "<td>{$permission->id}</td>";
                                    echo "<td>{$permission->name}</td>";
                                    echo "<td>{$permission->description}</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            } else {
                                echo "<div class='alert alert-warning'>No permissions found</div>";
                            }

                            echo "<hr>";

                            echo "<h5><i class='fas fa-search me-2'></i>Specific Checks:</h5>";
                            
                            // Check admin user
                            $adminUser = User::where('email', 'admin@example.com')->first();
                            if ($adminUser) {
                                echo "<div class='alert alert-success'>";
                                echo "<strong>✓ Admin user found:</strong> {$adminUser->name} ({$adminUser->email})<br>";
                                echo "<strong>Has admin role:</strong> " . ($adminUser->hasRole('admin') ? 'YES' : 'NO') . "<br>";
                                echo "<strong>Has user role:</strong> " . ($adminUser->hasRole('user') ? 'YES' : 'NO');
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-danger'>";
                                echo "<strong>❌ Admin user NOT found!</strong><br>";
                                echo "Email: admin@example.com";
                                echo "</div>";
                            }

                            // Check regular users
                            $regularUsers = User::where('email', '!=', 'admin@example.com')->get();
                            if ($regularUsers->count() > 0) {
                                echo "<div class='alert alert-info'>";
                                echo "<strong>Regular users ({$regularUsers->count()}):</strong><br>";
                                foreach ($regularUsers as $user) {
                                    echo "- {$user->name} ({$user->email}): " . ($user->hasRole('user') ? 'User role' : 'No role') . "<br>";
                                }
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-warning'>No regular users found</div>";
                            }

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
                                <i class="fas fa-cogs me-2"></i>Run Update
                            </a>
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                            </a>
                            <a href="http://127.0.0.1:8000" class="btn btn-info">
                                <i class="fas fa-home me-2"></i>Go to Home
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