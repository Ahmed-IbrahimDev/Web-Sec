<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Laptop Pro',
                'description' => 'High-performance laptop with 16GB RAM, 512GB SSD, and a powerful processor.',
                'price' => 1299.99,
            ],
            [
                'name' => 'Smartphone X',
                'description' => 'Latest smartphone with 6.5-inch display, 128GB storage, and triple camera system.',
                'price' => 899.99,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life.',
                'price' => 249.99,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracker and smartwatch with heart rate monitor and GPS.',
                'price' => 199.99,
            ],
            [
                'name' => 'Tablet Pro',
                'description' => '10-inch tablet with high-resolution display, 64GB storage, and long battery life.',
                'price' => 499.99,
            ],
            [
                'name' => 'Wireless Earbuds',
                'description' => 'True wireless earbuds with touch controls and charging case.',
                'price' => 129.99,
            ],
            [
                'name' => 'Desktop Computer',
                'description' => 'Powerful desktop computer with 32GB RAM, 1TB SSD, and dedicated graphics card.',
                'price' => 1499.99,
            ],
            [
                'name' => 'Gaming Console',
                'description' => 'Next-generation gaming console with 1TB storage and 4K gaming capability.',
                'price' => 499.99,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with customizable buttons and long battery life.',
                'price' => 49.99,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable Bluetooth speaker with 360-degree sound and waterproof design.',
                'price' => 79.99,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => '2TB external hard drive with USB-C connection and fast data transfer.',
                'price' => 89.99,
            ],
            [
                'name' => 'Wireless Keyboard',
                'description' => 'Slim wireless keyboard with backlit keys and multi-device connectivity.',
                'price' => 69.99,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}