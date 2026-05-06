<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class ProductCollection extends ResourceCollection
{
    // Define qual Resource será usado para mapear os itens
    public $collects = ProductResource::class;

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            // O Laravel automaticamente injeta 'links' e 'meta' (current_page, per_page, total) 
            // quando paginamos com LengthAwarePaginator na raiz da resposta.
        ];
    }
}