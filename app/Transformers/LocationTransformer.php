<?php

namespace App\Transformers;

use App\Models\Item;
use App\Models\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    public function transform(Location $location): array
    {
        return [
            'address' => $location->address,
            'zip_code' => $location->zip_code,
            'city' => $location->city()->first()->name,
            'state' => $location->state()->first()->name,
            'country' => $location->country()->first()->name,
        ];
    }
}
