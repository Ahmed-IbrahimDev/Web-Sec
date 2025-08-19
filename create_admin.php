<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

// Create admin user
$user = User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
]);

// Get admin role
$adminRole = Role::where('name', 'admin')->first();

if ($adminRole) {
    // Assign admin role to user
    $user->roles()->attach($adminRole);
    echo "Admin user created successfully!\n";
    echo "Email: admin@example.com\n";
    echo "Password: password\n";
} else {
    echo "Admin role not found!\n";
}
?>