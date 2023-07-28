<?php

namespace App\Models\Enums;

trait EnumHelper
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
