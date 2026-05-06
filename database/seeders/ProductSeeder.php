<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Enums\CategoryEnum;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Smartphone Pro', 'category' => CategoryEnum::ELECTRONICS, 'price' => 4500.00, 'stock' => 15, 'is_active' => true],
            ['name' => 'Camiseta Algodão', 'category' => CategoryEnum::CLOTHING, 'price' => 89.90, 'stock' => 50, 'is_active' => true],
            ['name' => 'Cafeteira Express', 'category' => CategoryEnum::HOME, 'price' => 350.00, 'stock' => 5, 'is_active' => false], // Inativo
            ['name' => 'Macbook Air', 'category' => CategoryEnum::ELECTRONICS, 'price' => 8000.00, 'stock' => 10, 'is_active' => true],
            ['name' => 'Livro Laravel Design Patterns', 'category' => CategoryEnum::BOOKS, 'price' => 120.00, 'stock' => 20, 'is_active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}