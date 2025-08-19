<?php

// Bootstrap the Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Attempting to connect to the database...\n";
echo "DB_HOST: " . config('database.connections.mysql.host') . "\n";
echo "DB_DATABASE: " . config('database.connections.mysql.database') . "\n";
echo "DB_USERNAME: " . config('database.connections.mysql.username') . "\n\n";

try {
    DB::connection()->getPdo();
    echo "\033[32mSUCCESS: Database connection established successfully!\033[0m\n";
} catch (\Exception $e) {
    echo "\033[31mERROR: Could not connect to the database.\033[0m\n";
    echo "Please check the following:\n";
    echo "1. Is your MySQL server running in XAMPP?\n";
    echo "2. Are the database credentials in your .env file correct?\n\n";
    echo "Error details: " . $e->getMessage() . "\n";
}
