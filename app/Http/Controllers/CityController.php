<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations\OpenApi as OA;

/**
 * Class CityController
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Trivago Case Study",
 *         @OA\License(name="MIT")
 *     ),
 *     @OA\Server(
 *         description="API server",
 *         url="http://localhost/api/documentation/",
 *     ),
 * )
 */
class CityController extends TrivagoController
{
    /**
     * @OA\Get(
     *     path="/cities/",
     *     summary="List all cities",
     *     operationId="index",
     *     tags={"City"},
     *     @OA\Response(
     *         response=200,
     *         description="A paginated JSON response of all cities",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PostResponse")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function index(int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        return response()->json(City::paginate($perPage));
    }
}
