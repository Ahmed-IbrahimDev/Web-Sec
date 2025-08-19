<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

try {
    // Delete existing admin user if exists
    User::where('email', 'admin@example.com')->delete();
    
    // Create admin user
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
    
    // Get admin role
    $adminRole = Role::where('name', 'admin')->first();
    
    if ($adminRole) {
        $user->roles()->attach($adminRole);
        echo "Admin user created successfully!\n";
        echo "Email: admin@example.com\n";
        echo "Password: password\n";
    } else {
        echo "Admin role not found! Creating admin role...\n";
        
        // Create admin role
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access',
        ]);
        
        $user->roles()->attach($adminRole);
        echo "Admin user and role created successfully!\n";
        echo "Email: admin@example.com\n";
        echo "Password: password\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 