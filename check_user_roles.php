<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

$emails = [
    'superadmin@example.com',
    'owner@example.com',
    'employee@example.com',
    'custmer@example.com',
    'user@example.com',
];

foreach ($emails as $email) {
    $user = \App\Models\User::where('email', $email)->first();
    if (!$user) {
        echo "$email => user not found\n";
        continue;
    }
    $roles = $user->roles()->pluck('name')->toArray();
    echo sprintf("%s => roles: [%s]\n", $email, implode(',', $roles));
}
