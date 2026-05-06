<?php

namespace App\Services;

use App\DTOs\ProductData;
use App\DTOs\ProductFilterData;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {}

    public function listProducts(ProductFilterData $filters): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "products_list_{$page}_" . md5(serialize($filters));

        return Cache::tags(['products'])->remember($cacheKey, now()->addMinutes(10), function () use ($filters) {
            return $this->repository->list($filters);
        });
    }

    public function getProduct(int $id): Product
    {
        return Cache::tags(['products'])->remember("product_{$id}", now()->addMinutes(10), function () use ($id) {
            return $this->repository->findById($id);
        });
    }

    public function createProduct(ProductData $data): Product
    {
        try {
            $this->invalidateCache();
            $product = $this->repository->create($data);

            Log::info('Product created successfully', [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->value
            ]);

            return $product;
        } catch (\Exception $e) {
            Log::error('Failed to create product', [
                'data' => (array) $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function updateProduct(int $id, ProductData $data): bool
    {
        try {
            $product = $this->repository->findById($id);

            // prevenir estoque negativo no update
            if ($data->stock < 0) {
                Log::warning('Attempted to update product with negative stock', [
                    'product_id' => $id,
                    'attempted_stock' => $data->stock
                ]);
                throw new \InvalidArgumentException("O estoque não pode ser negativo.");
            }

            $this->invalidateCache();
            $updated = $this->repository->update($product, $data);

            if ($updated) {
                Log::info('Product updated successfully', [
                    'id' => $id,
                    'changes' => (array) $data
                ]);
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Failed to update product', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function deleteProduct(int $id): bool
    {
        try {
            $product = $this->repository->findById($id);
            
            $this->invalidateCache();
            $deleted = $this->repository->delete($product);

            Log::info('Product deleted (soft delete)', [
                'id' => $id,
                'name' => $product->name
            ]);

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Failed to delete product', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function invalidateCache(): void
    {
        Cache::tags(['products'])->flush();
        Log::debug('Product cache invalidated');
    }
}
