<?php

namespace App\Repositories;

use App\DTOs\ProductFilterData;
use App\DTOs\ProductData;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function list(ProductFilterData $filters): LengthAwarePaginator
    {
        return Product::query()
            ->when($filters->search, fn($q) => $q->where('name', 'ilike', "%{$filters->search}%"))
            ->when($filters->category, fn($q) => $q->where('category', $filters->category))
            ->when(!is_null($filters->is_active), fn($q) => $q->where('is_active', $filters->is_active))
            ->orderBy('id', 'desc')
            ->paginate($filters->per_page);
    }

    public function findById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(ProductData $data): Product
    {
        return Product::create($data->toArray());
    }

    public function update(Product $product, ProductData $data): bool
    {
        return $product->update($data->toArray());
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}