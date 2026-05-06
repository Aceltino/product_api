<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case ELETRONICOS = 'eletronicos';
    case VESTUARIO = 'vestuario';
    case ALIMENTOS = 'alimentos';
    case MOVEIS = 'moveis';
    case LIVROS = 'livros';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}