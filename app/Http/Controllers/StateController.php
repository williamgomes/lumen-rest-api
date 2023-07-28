<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\JsonResponse;

class StateController extends TrivagoController
{
    public function index(int $perPage = self::MIN_ITEMS_PER_PAGE): JsonResponse
    {
        return response()->json(State::paginate($perPage));
    }
}
