<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequestValidator;
use App\Services\ItemService;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends TrivagoController
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly ItemService $itemService
    )
    {}

    public function show(Request $request, int $reservationId): JsonResponse
    {
        $reservation = $this->reservationService->getActiveReservation($reservationId);

        if(!$reservation) {
            return $this->NotFoundResponse();
        }

        return response()->json($reservation);
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request, CreateReservationRequestValidator $createReservationRequestValidator): JsonResponse
    {
        $createReservationRequestValidator->validateRequest($request);

        if (!$this->reservationService->isReservationAcceptable($request)) {
            return $this->notAcceptableResponse();
        }

        DB::beginTransaction();

        try {
            $reservationId = $this->reservationService->createReservation($request);
            $this->itemService->adjustItemAvailability($request);
            DB::commit();

            $newResourceUri = route('reservation.show.one', ['reservationId' => $reservationId]);
            return $this->createSuccessResponse($newResourceUri);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->serversideErrorResponse($exception->getMessage());
        }
    }
}
