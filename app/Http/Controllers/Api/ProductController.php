<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\DTOs\ProductData;
use App\DTOs\ProductFilterData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service
    ) {}

    public function index(Request $request): ProductCollection
    {
        $filters = ProductFilterData::fromRequest($request->all());
        $products = $this->service->listProducts($filters);
        
        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $dto = ProductData::fromRequest($request->validated());
        $product = $this->service->createProduct($dto);
        
        return new ProductResource($product);
    }

    public function show(int $id): ProductResource
    {
        $product = $this->service->getProduct($id);
        
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $dto = ProductData::fromRequest($request->validated());
        $this->service->updateProduct($id, $dto);
        
        return response()->json(['message' => 'Produto atualizado com sucesso.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteProduct($id);
        
        return response()->json(null, 204);
    }
}