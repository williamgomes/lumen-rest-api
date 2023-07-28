<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\Enums\Categories;
use App\Models\State;
use App\Rules\CountryValidationRule;
use App\Rules\ForbiddenWordsValidationRule;
use App\Rules\StateValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class CreateItemRequestValidator extends AbstractRequestValidator
{
    private array $checkWords = [
        'Free',
        'Offer',
        'Book',
        'Website',
    ];

    protected function rules(Request $request): array
    {
        return [
            'name' => ['required', 'string', 'min:10', new ForbiddenWordsValidationRule($this->checkWords)],
            'category' => ['required', Rule::in(array_column(Categories::cases(), 'value'))],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'city' => ['required', 'numeric', 'exists:cities,id', new CountryValidationRule($request->input('country'), new City()), new StateValidationRule($request->input('state'), new City())],
            'state' => ['required', 'numeric', 'exists:states,id', new CountryValidationRule($request->input('country'), new State())],
            'country' => ['required', 'numeric', 'exists:countries,id'],
            'zip_code' => ['required', 'numeric', 'digits_between:5,5'],
            'address' => ['required', 'string'],
            'image' => ['required', 'string', 'url'],
            'reputation' => ['required', 'string', 'min:0', 'max:1000'],
            'price' => ['required', 'decimal:2', 'min:1'],
            'availability' => ['required', 'integer', 'min:1'],
        ];
    }

    protected function messages(): array
    {
        return [];
    }
}
