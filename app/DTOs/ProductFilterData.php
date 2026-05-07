<?php

namespace App\DTOs;

readonly class ProductFilterData
{
    public function __construct(
        public ?string $search,
        public ?string $category,
        public ?bool $is_active,
        public int $per_page = 10
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            category: $data['category'] ?? null,
            is_active: isset($data['is_active']) ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) : null,
            per_page: min((int) ($data['per_page'] ?? 15), 100)
        );
    }
}
