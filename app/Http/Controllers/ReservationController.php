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

    /**
     * @OA\Get(
     *     path="/api/reservations/{reservationId}",
     *     tags={"Reservations"},
     *     summary="Get a reservation",
     *     description="Get a specific reservation information by ID",
     *     operationId="showReservation",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="reservationId",
     *         in="path",
     *         description="ID of a specific reservation",
     *         required=false,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     * )
     */
    public function show(Request $request, int $reservationId): JsonResponse
    {
        $reservation = $this->reservationService->getActiveReservation($reservationId);

        if(!$reservation) {
            return $this->NotFoundResponse();
        }

        return response()->json($reservation);
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     tags={"Reservations"},
     *     summary="Create a new reservation.",
     *     operationId="Create a new reservation.",
     *     @OA\RequestBody(
     *         description="Input data format.",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="start_date",
     *                     description="Start date of a reservation equals or greater than today. Format dd/mm/yyyy.",
     *                     type="date",
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     description="End date of a reservation greater than or equals to start_date. Format dd/mm/yyyy.",
     *                     type="date",
     *                 ),
     *                 @OA\Property(
     *                     property="accommodation",
     *                     description="No of accommodation to reserve. Must be more than 0.",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="item_id",
     *                     description="ID of an item that is not deleted already and have more than required accommodations.",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The process was successful."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content."
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not acceptable."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="The server encountered an error."
     *     ),
     * )
     */
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
