<?php

namespace App\Enums\Tasks;

enum TaskSortFields: string
{
    case DUE_DATE = 'due_date';
    case CREATED_AT = 'created_at';
    case CREATED_DATE = 'created_date';
    case TITLE = 'title';
    case PRIORITY = 'priority';
    case STATUS = 'status';

    public static function default(): self
    {
        return self::DUE_DATE;
    }
}
