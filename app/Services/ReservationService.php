<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function isReservationAcceptable(Request $request): bool
    {
        $item = Item::where('id', $request->input('item_id'))
            ->where('deleted_at', null)
            ->first();

        if ($item && $item->availability >= $request->input('accommodation')) {
            return true;
        }

        return false;
    }

    public function getActiveReservation(int $reservationid): ?Reservation
    {
        return Reservation::where('id', $reservationid)
            ->where('deleted_at', null)
            ->first();
    }

    /**
     * @throws \Exception
     */
    public function createReservation(Request $request): int
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
        DB::beginTransaction();

        try {
            $reservation = new Reservation();
            $reservation->item_id = $request->input('item_id');
            $reservation->start_date = $startDate;
            $reservation->end_date = $endDate;
            $reservation->accommodation = $request->input('accommodation');

            $reservation->save();
            DB::commit();

            return $reservation->id;

        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }
}
