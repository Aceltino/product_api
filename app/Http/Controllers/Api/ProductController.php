<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\DTOs\ProductData;
use App\DTOs\ProductFilterData;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ProductService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = ProductFilterData::fromRequest($request->all());
        $paginator = $this->service->listProducts($filters);
        
        // Pega os itens formatados pelo Resource
        $data = ProductResource::collection($paginator)->resolve();
        
        // Pega a meta de paginação nativa
        $meta = [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage()
        ];

        return $this->success($data, 'Produtos listados com sucesso.', 200, $meta);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $dto = ProductData::fromRequest($request->validated());
        $product = $this->service->createProduct($dto);
        
        return $this->success(new ProductResource($product), 'Produto criado com sucesso.', 201);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->service->getProduct($id);
        
        return $this->success(new ProductResource($product), 'Produto encontrado.');
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $dto = ProductData::fromRequest($request->validated());
        $this->service->updateProduct($id, $dto);
        
        return $this->success(null, 'Produto atualizado com sucesso.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteProduct($id);
        
        return response()->json(null, 204); // 204 No Content não leva body
    }
}