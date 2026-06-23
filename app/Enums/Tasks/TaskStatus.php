<?php

namespace App\Enums\Tasks;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
