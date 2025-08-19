<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::beginTransaction();

    $products = [
        ['name' => 'Wireless Mouse', 'description' => 'Ergonomic 2.4G wireless mouse', 'price' => 19.99],
        ['name' => 'Mechanical Keyboard', 'description' => 'RGB backlit mechanical keyboard', 'price' => 59.90],
        ['name' => 'USB-C Cable', 'description' => 'Fast charging USB-C cable 1m', 'price' => 7.50],
        ['name' => 'Laptop Stand', 'description' => 'Aluminum adjustable laptop stand', 'price' => 29.00],
        ['name' => 'Headphones', 'description' => 'Over-ear noise-isolating headphones', 'price' => 39.99],
    ];

    foreach ($products as $p) {
        \App\Models\Product::firstOrCreate(
            ['name' => $p['name']],
            ['description' => $p['description'], 'price' => $p['price']]
        );
    }

    DB::commit();
    echo "Products seeded successfully.\n";
} catch (Exception $e) {
    DB::rollBack();
    echo 'Error: ' . $e->getMessage() . "\n";
}
