<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class CreateReservationRequestValidator extends AbstractRequestValidator
{
    protected function rules(Request $request): array
    {
        return [
            'item_id' => ['required', 'numeric', 'exists:items,id'],
            'start_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:now'],
            'end_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:start_date'],
            'accommodation' => ['required', 'numeric', 'min:1'],
        ];
    }

    protected function messages(): array
    {
        return [];
    }
}
