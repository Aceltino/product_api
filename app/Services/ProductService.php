<?php

namespace App\Services;

use App\DTOs\ProductData;
use App\DTOs\ProductFilterData;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
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
        $this->invalidateCache();
        return $this->repository->create($data);
    }

    public function updateProduct(int $id, ProductData $data): bool
    {
        $product = $this->repository->findById($id);

        // Regra de negócio extra: prevenir estoque negativo no update
        if ($data->stock < 0) {
            throw new \InvalidArgumentException("O estoque não pode ser negativo.");
        }

        $this->invalidateCache();
        return $this->repository->update($product, $data);
    }

    public function deleteProduct(int $id): bool
    {
        $product = $this->repository->findById($id);
        
        $this->invalidateCache();
        return $this->repository->delete($product);
    }

    private function invalidateCache(): void
    {
        Cache::tags(['products'])->flush();
    }
}