<?php
namespace Database\Factories;
use App\Models\Product;
use App\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
    protected $model = Product::class;

    public function definition(): array {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'category' => $this->faker->randomElement(CategoryEnum::cases())->value,
            'is_active' => true,
        ];
    }
}
