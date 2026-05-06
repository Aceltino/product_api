<?php

namespace App\Models;

use App\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'category', 'is_active'
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'is_active' => 'bool',
        'category' => CategoryEnum::class, // Conversão automática para Enum
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}