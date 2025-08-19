<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "Adding credit system to users table...\n";
    
    // Add credit column to users table if it doesn't exist
    if (!Schema::hasColumn('users', 'credit')) {
        Schema::table('users', function ($table) {
            $table->decimal('credit', 10, 2)->default(0.00)->after('password');
        });
        echo "✓ Added credit column to users table\n";
    } else {
        echo "✓ Credit column already exists\n";
    }
    
    // Create bought_products table
    if (!Schema::hasTable('bought_products')) {
        Schema::create('bought_products', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price_paid', 10, 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
            
            $table->index(['user_id', 'product_id']);
        });
        echo "✓ Created bought_products table\n";
    } else {
        echo "✓ bought_products table already exists\n";
    }
    
    // Update existing users with some initial credit for testing
    DB::table('users')->update(['credit' => 100.00]);
    echo "✓ Added initial credit (100.00) to all existing users\n";
    
    echo "Credit system setup complete!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
