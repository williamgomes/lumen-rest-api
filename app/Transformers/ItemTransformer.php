<?php

namespace App\Transformers;

use App\Models\Item as ItemModel;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class ItemTransformer extends TransformerAbstract
{
    protected array $availableIncludes = [
        'location'
    ];

    public function transform(ItemModel $item): array
    {
        return [
            'name' => $item->name,
            'rating' => $item->rating,
            'category' => $item->category,
            'image' => $item->image,
            'reputation' => $item->reputation,
            'reputation_badge' => $item->badge()->value('name'),
            'price' => $item->price,
            'availability' => $item->availability,
            'is_deleted' => !empty($item->deleted_at),
        ];
    }

    public function includeLocation(ItemModel $item): Item
    {
        $location = $item->location()->first();

        return $this->item($location, new LocationTransformer());
    }
}
