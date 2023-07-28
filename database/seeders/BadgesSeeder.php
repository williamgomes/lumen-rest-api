<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Enums\Badges;

class BadgesSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $badges = [
            [
                'name' => Badges::TYPE_RED->value,
                'min_value' => 0,
                'max_value' => 500,
            ],
            [
                'name' => Badges::TYPE_YELLOW->value,
                'min_value' => 501,
                'max_value' => 799,
            ],
            [
                'name' => Badges::TYPE_GREEN->value,
                'min_value' => 800,
                'max_value' => 1000,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
