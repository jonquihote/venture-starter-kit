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

        // Check if value is string and contains only Unicode letters, marks, and regular spaces
        // Must contain at least one letter or mark (not just spaces)
        if (! is_string($value) || ! preg_match('/\A[\pL\pM ]+\z/u', $value) || ! preg_match('/[\pL\pM]/u', $value)) {
            $fail(__('alpha::rules/valid_name.invalid_characters'));
        }
    }
}
