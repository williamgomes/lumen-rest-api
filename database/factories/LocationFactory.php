<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $city = City::all()->random();
    	return [
    	    'item_id' => Item::all()->random()->id,
    	    'address' => $this->faker->address,
    	    'zip_code' => $this->faker->numberBetween(10000, 99999),
            'country_id' => $city->country()->getParentKey(),
            'state_id' => $city->state()->getParentKey(),
            'city_id' => $city->id,
        ];
    }
}
