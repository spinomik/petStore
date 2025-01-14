<?php

namespace App\Enums;

enum PetStatusEnum: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function getAll(): array
    {
        return array_column(self::cases(), 'value');
    }
}
