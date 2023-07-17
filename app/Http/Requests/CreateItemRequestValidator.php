<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\Enums\Badges;
use App\Models\Enums\Categories;
use App\Models\State;
use App\Rules\CountryValidationRule;
use App\Rules\ForbiddenWordsValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class CreateItemRequestValidator implements RequestValidatorInterface
{
    use ProvidesConvenienceMethods;

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
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'city' => ['required', 'integer', 'exists:cities,id', new CountryValidationRule($request->input('country'), new City())],
            'state' => ['required', 'integer', 'exists:states,id', new CountryValidationRule($request->input('country'), new State())],
            'country' => ['required', 'integer', 'exists:countries,id'],
            'zip_code' => ['required', 'integer', 'min:5', 'max:5'],
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

    /**
     * @throws ValidationException
     */
    public function validateRequest(Request $request): void
    {
        $this->validate($request, $this->rules($request), $this->messages());
    }
}
