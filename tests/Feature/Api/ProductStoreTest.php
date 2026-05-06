<?php
namespace Tests\Feature\Api;
use App\Enums\CategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductStoreTest extends TestCase {
    use RefreshDatabase;
    public function test_should_create_product_with_valid_data() {
        $validCategory = CategoryEnum::cases()[0]->value;
        $payload = [
            'name' => 'iPhone 15',
            'price' => 4999.99,
            'stock' => 10,
            'category' => $validCategory
        ];
        $response = $this->postJson('/api/v1/products', $payload);
        $response->assertStatus(201);
    }
    public function test_should_fail_when_price_is_negative() {
        $payload = ['name' => 'a', 'price' => -1, 'stock' => 1, 'category' => CategoryEnum::cases()[0]->value];
        $this->postJson('/api/v1/products', $payload)->assertStatus(422);
    }
}
