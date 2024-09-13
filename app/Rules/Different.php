<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Different implements ValidationRule
{

    public function __construct(
        private string $fieldName,
        private string $messageAttribute
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === request()->get($this->fieldName)) {
            $fail("The $this->messageAttribute cannot be same.");
        }
    }

}
