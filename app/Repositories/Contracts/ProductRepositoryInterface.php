<?php

namespace App\Repositories\Contracts;

use App\DTOs\ProductFilterData;
use App\DTOs\ProductData;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function list(ProductFilterData $filters): LengthAwarePaginator;
    public function findById(int $id): Product;
    public function create(ProductData $data): Product;
    public function update(Product $product, ProductData $data): bool;
    public function delete(Product $product): bool;
}