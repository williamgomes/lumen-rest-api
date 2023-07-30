<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\JsonResponse;

class StateController extends TrivagoController
{
    /**
     * @OA\Get(
     *     path="/api/states/perPage/{perPage}",
     *     tags={"Geo"},
     *     summary="Get all states with pagination",
     *     description="Get all states available in the system with all relevant information",
     *     operationId="states",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many states will be shown per page",
     *         required=false,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function index(int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        return response()->json(State::paginate($perPage));
    }
}
