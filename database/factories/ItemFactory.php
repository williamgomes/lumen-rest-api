<?php

namespace Database\Factories;

use App\Models\Badge;
use App\Models\Hotelier;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->unique()->name,
            'hotelier_id' => Hotelier::all()->random()->id,
    	    'rating' => $this->faker->numberBetween(0, 5),
    	    'category' => $this->faker->randomElement([
                "hotel",
                "alternative",
                "hostel",
                "lodge",
                "resort",
                "guest-house",
                ]
            ),
    	    'image' => $this->faker->imageUrl,
    	    'reputation' => $this->faker->numberBetween(0, 1000),
    	    'badge_id' => Badge::all()->random()->id,
    	    'price' => $this->faker->numberBetween(0, 1000),
    	    'availability' => $this->faker->numberBetween(0, 10),
    	];
    }
}
