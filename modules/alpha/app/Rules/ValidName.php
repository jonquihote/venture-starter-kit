<?php

namespace Venture\Alpha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidName implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Skip validation if value is empty (required rule handles this)
        if (empty($value)) {
            return;
        }

        // Check if value is string and contains only ASCII letters (uppercase, lowercase) and regular spaces
        // Must contain at least one letter (not just spaces)
        if (! is_string($value) || ! preg_match('/\A[A-Za-z ]+\z/', $value) || ! preg_match('/[A-Za-z]/', $value)) {
            $fail(__('alpha::rules/valid_name.invalid_characters'));
        }
    }
}
