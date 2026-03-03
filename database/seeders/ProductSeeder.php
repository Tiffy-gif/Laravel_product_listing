<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            // Electronics
            [
                'id' => 1,
                'category_id' => 1,
                'productName' => 'Smartphone X100',
                'price' => 699.99,
                'quantity' => 50,
                'warranty' => 12,
                'description' => 'High-performance smartphone with AMOLED display.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'productName' => 'Wireless Headphones',
                'price' => 149.99,
                'quantity' => 120,
                'warranty' => 12,
                'description' => 'Noise-cancelling Bluetooth headphones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'productName' => '4K Smart TV',
                'price' => 899.99,
                'quantity' => 30,
                'warranty' => 12,
                'description' => 'Ultra HD 4K Smart TV with HDR and built-in apps.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'productName' => 'Gaming Laptop',
                'price' => 1299.99,
                'quantity' => 20,
                'warranty' => 12,
                'description' => 'High-end gaming laptop with RTX graphics card.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Clothing
            [
                'id' => 5,
                'category_id' => 2,
                'productName' => 'Men’s T-Shirt',
                'price' => 19.99,
                'quantity' => 200,
                'warranty' => 6,
                'description' => '100% cotton casual T-shirt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'productName' => 'Women’s Summer Dress',
                'price' => 39.99,
                'quantity' => 150,
                'warranty' => 6,
                'description' => 'Lightweight floral dress for summer wear.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'category_id' => 2,
                'productName' => 'Unisex Hoodie',
                'price' => 29.99,
                'quantity' => 100,
                'warranty' => 6,
                'description' => 'Fleece-lined hoodie for casual comfort.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'category_id' => 2,
                'productName' => 'Leather Jacket',
                'price' => 89.99,
                'quantity' => 40,
                'warranty' => 6,
                'description' => 'Genuine leather jacket for stylish outerwear.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Home & Kitchen
            [
                'id' => 9,
                'category_id' => 3,
                'productName' => 'Electric Kettle',
                'price' => 29.99,
                'quantity' => 80,
                'warranty' => 12,
                'description' => 'Stainless steel electric kettle with auto shut-off.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'category_id' => 3,
                'productName' => 'Microwave Oven',
                'price' => 149.99,
                'quantity' => 35,
                'warranty' => 12,
                'description' => 'Compact microwave oven with multiple cooking modes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'category_id' => 3,
                'productName' => 'Blender',
                'price' => 59.99,
                'quantity' => 60,
                'warranty' => 12,
                'description' => 'High-speed blender for smoothies and soups.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'category_id' => 3,
                'productName' => 'Air Fryer',
                'price' => 99.99,
                'quantity' => 45,
                'warranty' => 12,
                'description' => 'Oil-less air fryer for healthier cooking.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
