<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

abstract class AbstractRequestValidator
{
    use ProvidesConvenienceMethods;

    abstract protected function rules(Request $request): array;
    abstract protected function messages(): array;

    /**
     * @throws ValidationException
     */
    public function validateRequest(Request $request): void
    {
        $this->validate($request, $this->rules($request), $this->messages());
    }
}
