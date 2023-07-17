<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ForbiddenWordsValidationRule implements Rule
{
    public function __construct(private readonly array $forbiddenWords)
    {
    }

    public function passes($attribute, $value): bool
    {
        foreach ($this->forbiddenWords as $forbiddenWord) {
            if (stripos($value, $forbiddenWord) !== false) {
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return 'The :attribute contains forbidden word(s).';
    }
}
