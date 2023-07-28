<?php

namespace App\Models\Enums;

enum Categories: string
{
    use EnumHelper;
    case HOTEL = 'hotel';
    case ALTERNATIVE = 'alternative';
    case HOSTEL = 'hostel';
    case LODGE = 'lodge';
    case RESORT = 'resort';
    case GUESTHOUSE = 'guest-house';
}
