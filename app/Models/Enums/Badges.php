<?php

namespace App\Models\Enums;

use App\Models\Badge;

enum Badges: string
{
    use EnumHelper;
    case TYPE_RED = 'red';
    case TYPE_YELLOW = 'yellow';
    case TYPE_GREEN = 'green';

    public static function getBadgeTypeIdByReputation(int $reputation = 0): string
    {
        return match (true) {
            $reputation >= 0 && $reputation <= 500 => Badge::where('name', self::TYPE_RED->value)->value('id'),
            $reputation >= 501 && $reputation <= 799 => Badge::where('name', self::TYPE_YELLOW->value)->value('id'),
            $reputation >= 800 && $reputation <= 1000 => Badge::where('name', self::TYPE_GREEN->value)->value('id'),
        };
    }
}
