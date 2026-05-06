<?php

namespace App\DTOs;

use App\Enums\CategoryEnum;

readonly class ProductData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $price,
        public int $stock,
        public CategoryEnum $category,
        public bool $is_active = true,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            name: $validated['name'],
            description: $validated['description'] ?? null,
            price: (float) $validated['price'],
            stock: (int) $validated['stock'],
            category: $validated['category'] instanceof CategoryEnum 
                        ? $validated['category'] 
                        : CategoryEnum::from($validated['category']),
            is_active: (bool) ($validated['is_active'] ?? true),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category->value,
            'is_active' => $this->is_active,
        ];
    }
}