<?php

namespace App\Http\Controllers;


use App\Models\Country;
use Illuminate\Http\JsonResponse;

class CountryController extends TrivagoController
{
    /**
     * @OA\Get(
     *     path="/api/countries/perPage/{perPage}",
     *     tags={"Geo"},
     *     summary="Get all countries with pagination",
     *     description="Get all countries available in the system with all relevant information",
     *     operationId="countries",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="perPage",
     *         in="path",
     *         description="Determine how many countries will be shown per page",
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
        return response()->json(Country::paginate($perPage));
    }
}
