<?php

namespace Venture\Alpha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUsername implements ValidationRule
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

        // Check length requirements (4-16 characters)
        if (! is_string($value) || strlen($value) < 4 || strlen($value) > 16) {
            $fail(__('alpha::rules/valid_username.length'));
        }

        // Check if starts with a lowercase letter
        if (! preg_match('/^[a-z]/', $value)) {
            $fail(__('alpha::rules/valid_username.start_letter'));
        }

        // Check if ends with a letter or number
        if (! preg_match('/[a-z0-9]$/', $value)) {
            $fail(__('alpha::rules/valid_username.end_letter_number'));
        }

        // Check for allowed characters only (lowercase letters, numbers, dots, underscores)
        if (! preg_match('/^[a-z0-9._]+$/', $value)) {
            $fail(__('alpha::rules/valid_username.allowed_chars'));
        }

        // Check for no consecutive symbols
        if (preg_match('/[._]{2}/', $value)) {
            $fail(__('alpha::rules/valid_username.no_consecutive'));
        }
    }
}
