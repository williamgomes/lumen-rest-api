<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

interface RequestValidatorInterface
{
    function validateRequest(Request $request): void;
}
