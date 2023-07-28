<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Hotelier;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (count(Badge::all()->toArray()) === 0) {
            $this->call(BadgesSeeder::class);
            $this->command->info('Badges table seeded successfully!');
        }

        $countriesPath = database_path('migrations/sql/countries.sql');
        DB::unprepared(file_get_contents($countriesPath));
        $this->command->info('Countries table seeded successfully!');

        $statesPath = database_path('migrations/sql/states.sql');
        DB::unprepared(file_get_contents($statesPath));
        $this->command->info('States table seeded successfully!');

        $citiesPath = database_path('migrations/sql/city_part01.sql');
        DB::unprepared(file_get_contents($citiesPath));
        $citiesPath = database_path('migrations/sql/city_part02.sql');
        DB::unprepared(file_get_contents($citiesPath));
        $citiesPath = database_path('migrations/sql/city_part03.sql');
        DB::unprepared(file_get_contents($citiesPath));
        $citiesPath = database_path('migrations/sql/city_part04.sql');
        DB::unprepared(file_get_contents($citiesPath));
        $this->command->info('Cities table seeded successfully!');

        Hotelier::factory(2)
            ->create();
        $this->command->info('Hotelier table seeded successfully!');

        Item::factory(20)
            ->has(Location::factory())
            ->count(20)
            ->create();
        $this->command->info('Items & Locations table seeded successfully!');
    }
}
