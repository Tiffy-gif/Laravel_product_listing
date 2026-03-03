<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'categoryName' => 'Electronics',
                'description' => 'Devices, gadgets, and accessories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'categoryName' => 'Clothing',
                'description' => 'Men’s and women’s fashion items.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'categoryName' => 'Home & Kitchen',
                'description' => 'Furniture, appliances, and decor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
