<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    protected $model = Badge::class;
    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->randomElement([
                'red',
                'yellow',
                'green',
            ]),
    	    'min_value' => function (array $attributes) {
                // Retrieve the 'min_value' from the attributes array
                $name = $attributes['name'];

                return match ($name) {
                    default => 0,
                    'yellow' => 501,
                    'green' => 800,
                };
            },
            'max_value' => function (array $attributes) {
                // Retrieve the 'min_value' from the attributes array
                $name = $attributes['name'];

                return match ($name) {
                    default => 500,
                    'yellow' => 799,
                    'green' => 1000,
                };
            },
    	];
    }
}
