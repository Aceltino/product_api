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

/**
 * @group Gestão de Produtos
 *
 * Endpoints para gerenciar o catálogo de produtos, incluindo estoque e filtragem.
 */
class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ProductService $service
    ) {}

    /**
     * Listar Produtos
     *
     * Retorna uma lista paginada de produtos com filtros aplicáveis.
     * * @queryParam search string Termo para busca no nome ou descrição. Example: iPhone
     * @queryParam category string Filtrar por categoria. Example: electronics
     * @queryParam is_active boolean Filtrar por status. Example: true
     * @queryParam page int Página atual. Example: 1
     * @queryParam per_page int Itens por página. Example: 10
     * * @response 200 {
     * "status": "success",
     * "message": "Produtos listados com sucesso.",
     * "data": [{ "id": 1, "name": "iPhone 15", "price": 4999.99, "stock": 10, "category": "electronics" }],
     * "meta": { "total": 1, "per_page": 10, "current_page": 1, "last_page": 1 }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $filters = ProductFilterData::fromRequest($request->all());
        $paginator = $this->service->listProducts($filters);
        
        $data = ProductResource::collection($paginator)->resolve();
        
        $meta = [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage()
        ];

        return $this->success($data, 'Produtos listados com sucesso.', 200, $meta);
    }

    /**
     * Criar Produto
     * * Cria um novo registro de produto no banco de dados.
     *
     * @bodyParam name string required Nome do produto. Example: iPhone 15
     * @bodyParam price float required Preço unitário. Example: 4999.99
     * @bodyParam stock int required Quantidade em estoque. Example: 10
     * @bodyParam category string required Categoria do produto. Example: electronics
     * * @response 201 {
     * "status": "success",
     * "message": "Produto criado com sucesso.",
     * "data": { "id": 1, "name": "iPhone 15", "price": 4999.99, "stock": 10, "category": "electronics" }
     * }
     * @response 422 {
     * "message": "The name field is required.",
     * "errors": { "name": ["The name field is required."] }
     * }
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $dto = ProductData::fromRequest($request->validated());
        $product = $this->service->createProduct($dto);
        
        return $this->success(new ProductResource($product), 'Produto criado com sucesso.', 201);
    }

    /**
     * Visualizar Produto
     * * Retorna os detalhes de um produto específico através do ID.
     * * @urlParam id int required O ID do produto. Example: 1
     * * @response 200 {
     * "status": "success",
     * "message": "Produto encontrado.",
     * "data": { "id": 1, "name": "iPhone 15", "price": 4999.99, "stock": 10, "category": "electronics" }
     * }
     * @response 404 {
     * "status": "error",
     * "message": "Produto não encontrado."
     * }
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->service->getProduct($id);
        
        return $this->success(new ProductResource($product), 'Produto encontrado.');
    }

    /**
     * Atualizar Produto
     * * Atualiza as informações de um produto existente.
     * * @urlParam id int required O ID do produto. Example: 1
     * @bodyParam name string Nome do produto. Example: iPhone 15 Pro
     * @bodyParam price float Preço unitário. Example: 5999.99
     * * @response 200 {
     * "status": "success",
     * "message": "Produto atualizado com sucesso.",
     * "data": null
     * }
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $dto = ProductData::fromRequest($request->validated());
        $this->service->updateProduct($id, $dto);
        
        return $this->success(null, 'Produto atualizado com sucesso.');
    }

    /**
     * Excluir Produto
     * * Remove permanentemente um produto do catálogo.
     * * @urlParam id int required O ID do produto. Example: 1
     * * @response 204
     * @response 404 {
     * "status": "error",
     * "message": "Produto não encontrado."
     * }
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteProduct($id);
        
        return response()->json(null, 204);
    }
}