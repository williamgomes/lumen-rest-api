<?php

namespace App\Http\Controllers;


use App\Models\Country;
use Illuminate\Http\JsonResponse;

class CountryController extends TrivagoController
{
    public function index(int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        return response()->json(Country::paginate($perPage));
    }
}
