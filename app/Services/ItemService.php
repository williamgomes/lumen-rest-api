<?php

namespace App\Services;

use App\Models\Enums\Badges;
use App\Models\Item;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class ItemService
{

    public function getActiveItemByHotelierIdAndOptionalItemId(int $hotelierId, int $itemId = 0, array $options = []): ?Item
    {
        return Item::where('hotelier_id', $hotelierId)
            ->where('id', $itemId)
            ->where('deleted_at', null)
            ->first();
    }

    public function markAsDeleted(Item $item): void
    {
        $item->deleted_at = Carbon::now();
        $item->save();
    }

    /**
     * @throws \Exception
     */
    public function createItem(Request $request): int
    {
        DB::beginTransaction();

        try {
            $item = new Item();
            $this->assignValueToItem($request, $item);
            $item->save();

            $item->location()->save(
                new Location([
                    'item_id' => $item->id,
                    'address' => $request->input('address'),
                    'zip_code' => $request->input('zip_code'),
                    'city_id' => $request->input('city'),
                    'country_id' => $request->input('country'),
                    'state_id' => $request->input('state'),
                ])
            );

            $item->push();
            DB::commit();

            return $item->id;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    #[NoReturn] public function updateItem(Request $request): void
    {
        $item = $this->getActiveItemByHotelierIdAndOptionalItemId($request->hotelierId, $request->itemId);
        $location = Location::where('id', $item->location()->value('id'))->first();
        DB::beginTransaction();

        try {
            $this->assignValueToItem($request, $item);
            $item->update();

            $location->address = $request->input('address');
            $location->zip_code = $request->input('zip_code');
            $location->city_id = $request->input('city');
            $location->country_id = $request->input('country');
            $location->state_id = $request->input('state');
            $location->update();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function assignValueToItem(Request $request, ?Item $item): void
    {
        $item->hotelier_id = $request->hotelierId;
        $item->name = $request->input('name');
        $item->rating = $request->input('rating');
        $item->category = $request->input('category');
        $item->image = $request->input('image');
        $item->reputation = $request->input('reputation');
        $item->badge_id = Badges::getBadgeTypeIdByReputation($request->input('reputation'));
        $item->price = $request->input('price');
        $item->availability = $request->input('availability');
    }

    public function adjustItemAvailability(Request $request): void
    {
        $item = Item::find($request->input('item_id'));
        $newAvailability = $item->availability - $request->accommodation;
        $item->availability = $newAvailability;
        $item->save();
    }
}
