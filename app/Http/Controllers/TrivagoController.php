<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class TrivagoController extends BaseController
{
    protected const MIN_ITEMS_PER_PAGE = 10;
}
