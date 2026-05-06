<?php
namespace Tests\Feature\Api;
use App\Models\Product;
use App\Enums\CategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductIndexTest extends TestCase {
    use RefreshDatabase;
    public function test_should_filter_products_by_category() {
        $category = CategoryEnum::cases()[0]->value;
        Product::factory()->create(['category' => $category]);
        $response = $this->getJson('/api/v1/products?category=' . $category);
        $response->assertStatus(200);
    }
}
