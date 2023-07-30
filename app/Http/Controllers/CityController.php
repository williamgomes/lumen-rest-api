<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;

class CityController extends TrivagoController
{
    /**
     * @OA\Get(
     *     path="/api/cities/perPage/{perPage}",
     *     tags={"Geo"},
     *     summary="Get all cities with pagination",
     *     description="Get all cities available in the system with all relevant information",
     *     operationId="cities",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many cities will be shown per page",
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
        return response()->json(City::paginate($perPage));
    }
}
