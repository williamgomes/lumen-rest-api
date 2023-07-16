<?php

namespace Database\Factories;

use App\Models\Hotelier;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelierFactory extends Factory
{
    protected $model = Hotelier::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->name,
    	];
    }
}
