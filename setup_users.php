<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

// --- Configuration ---
$superAdminEmail = 'superadmin@websec.com';
$adminEmail = 'admin@websec.com';
$password = 'password123'; // Use this password for both users

// --- Create Roles if they don't exist ---
$superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
$adminRole = Role::firstOrCreate(['name' => 'admin']);
$userRole = Role::firstOrCreate(['name' => 'user']);

echo "Roles checked/created successfully.\n";

// --- Create Super Admin User ---
$superAdmin = User::where('email', $superAdminEmail)->first();
if (!$superAdmin) {
    $superAdmin = User::create([
        'name' => 'Super Admin',
        'email' => $superAdminEmail,
        'password' => Hash::make($password),
    ]);
    $superAdmin->roles()->sync([$superAdminRole->id]);
    echo "Super Admin user created successfully.\n";
} else {
    $superAdmin->roles()->sync([$superAdminRole->id]);
    echo "Super Admin user already exists, role assigned.\n";
}

// --- Create Admin User ---
$adminUser = User::where('email', $adminEmail)->first();
if (!$adminUser) {
    $adminUser = User::create([
        'name' => 'Admin User',
        'email' => $adminEmail,
        'password' => Hash::make($password),
    ]);
    $adminUser->roles()->sync([$adminRole->id]);
    echo "Admin user created successfully.\n";
} else {
    $adminUser->roles()->sync([$adminRole->id]);
    echo "Admin user already exists, role assigned.\n";
}

echo "\n--- User Credentials ---\n";
echo "Super Admin Email: " . $superAdminEmail . "\n";
echo "Admin Email:       " . $adminEmail . "\n";
echo "Password (for both): " . $password . "\n";
echo "\nScript finished successfully!\n";
