<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case ELECTRONICS = 'electronics';
    case CLOTHING = 'clothing';
    case HOME = 'home';
    case FOOD = 'food';
    case BOOKS = 'books';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}