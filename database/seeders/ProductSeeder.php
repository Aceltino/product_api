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
            ['name' => 'Smartphone Pro', 'category' => CategoryEnum::ELETRONICOS, 'price' => 4500.00, 'stock' => 15, 'is_active' => true],
            ['name' => 'Camiseta Algodão', 'category' => CategoryEnum::VESTUARIO, 'price' => 89.90, 'stock' => 50, 'is_active' => true],
            ['name' => 'Cafeteira Express', 'category' => CategoryEnum::MOVEIS, 'price' => 350.00, 'stock' => 5, 'is_active' => false],
            ['name' => 'Macbook Air', 'category' => CategoryEnum::ELETRONICOS, 'price' => 8000.00, 'stock' => 10, 'is_active' => true],
            ['name' => 'Livro Laravel Design Patterns', 'category' => CategoryEnum::LIVROS, 'price' => 120.00, 'stock' => 20, 'is_active' => true],
            ['name' => 'Fone Bluetooth', 'category' => CategoryEnum::ELETRONICOS, 'price' => 299.00, 'stock' => 30, 'is_active' => true],
            ['name' => 'Calça Jeans', 'category' => CategoryEnum::VESTUARIO, 'price' => 199.00, 'stock' => 12, 'is_active' => true],
            ['name' => 'Mesa de Escritório', 'category' => CategoryEnum::MOVEIS, 'price' => 850.00, 'stock' => 3, 'is_active' => true],
            ['name' => 'Snack Saudável', 'category' => CategoryEnum::ALIMENTOS, 'price' => 15.50, 'stock' => 100, 'is_active' => true],
            ['name' => 'Teclado Mecânico', 'category' => CategoryEnum::ELETRONICOS, 'price' => 450.00, 'stock' => 0, 'is_active' => false],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}