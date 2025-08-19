<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

try {
    \Illuminate\Support\Facades\DB::beginTransaction();

    $accounts = [
        ['email' => 'superadmin@example.com', 'name' => 'Super Admin', 'role' => 'super_admin'],
        ['email' => 'owner@example.com',       'name' => 'Owner User',   'role' => 'owner'],
        ['email' => 'employee@example.com',    'name' => 'Employee User','role' => 'employee'],
        ['email' => 'custmer@example.com',     'name' => 'Custmer User', 'role' => 'custmer'],
        ['email' => 'user@example.com',        'name' => 'Regular User', 'role' => 'user'],
    ];

    foreach ($accounts as $acc) {
        $user = \App\Models\User::firstOrCreate(
            ['email' => $acc['email']],
            [
                'name' => $acc['name'],
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'credit' => in_array($acc['role'], ['custmer','user']) ? 100 : 0,
            ]
        );

        $role = \App\Models\Role::firstOrCreate(['name' => $acc['role']]);
        $user->roles()->syncWithoutDetaching([$role->id]);
    }

    \Illuminate\Support\Facades\DB::commit();

    echo "Sample accounts ensured:\n";
    foreach ($accounts as $acc) {
        echo sprintf("- %s => %s / password (role: %s)\n", $acc['name'], $acc['email'], $acc['role']);
    }
} catch (Exception $e) {
    \Illuminate\Support\Facades\DB::rollBack();
    echo 'Error: ' . $e->getMessage() . "\n";
}
