<?php

namespace Venture\Alpha\Database\Factories\Concerns;

trait GeneratesValidUsernames
{
    /**
     * Generate a username that complies with ValidUsername rule.
     * - 4-16 characters
     * - Starts with lowercase letter
     * - Ends with letter or number
     * - Only lowercase letters, numbers, dots, underscores
     * - No consecutive symbols
     */
    protected function generateValidUsername(): string
    {
        // Generate base username from faker
        $baseOptions = [
            fn () => strtolower($this->faker->firstName()),
            fn () => strtolower($this->faker->lastName()),
            fn () => strtolower($this->faker->userName()),
            fn () => strtolower($this->faker->word()),
        ];

        $base = $baseOptions[array_rand($baseOptions)]();

        // Clean the base to only contain allowed characters
        $base = preg_replace('/[^a-z0-9._]/', '', $base);

        // Ensure it starts with a lowercase letter
        if (empty($base) || ! preg_match('/^[a-z]/', $base)) {
            $base = $this->faker->randomLetter() . $base;
        }

        // Ensure proper length (4-16 characters)
        if (strlen($base) < 4) {
            // Add random suffix to meet minimum length
            $suffixOptions = [
                $this->faker->numberBetween(10, 999),
                $this->faker->randomLetter() . $this->faker->randomLetter(),
                '_' . $this->faker->randomLetter(),
                '.' . $this->faker->randomLetter(),
            ];
            $base .= $suffixOptions[array_rand($suffixOptions)];
        } elseif (strlen($base) > 16) {
            // Truncate to maximum length
            $base = substr($base, 0, 16);
        }

        // Fix consecutive symbols (dots or underscores)
        $base = preg_replace('/([._]){2,}/', '$1', $base);

        // Ensure it ends with a letter or number
        if (! preg_match('/[a-z0-9]$/', $base)) {
            // Remove trailing symbols and add valid ending
            $base = rtrim($base, '._');
            if (strlen($base) < 16) {
                $base .= $this->faker->randomElement([$this->faker->randomLetter(), $this->faker->randomDigit()]);
            }
        }

        // Final validation and fallback
        if (strlen($base) < 4 || strlen($base) > 16 ||
            ! preg_match('/^[a-z]/', $base) ||
            ! preg_match('/[a-z0-9]$/', $base) ||
            ! preg_match('/^[a-z0-9._]+$/', $base) ||
            preg_match('/[._]{2}/', $base)) {
            // Fallback to a guaranteed valid username
            $prefix = $this->faker->randomLetter();
            $middle = $this->faker->randomLetter() . $this->faker->randomDigit();
            $suffix = $this->faker->randomElement([$this->faker->randomLetter(), $this->faker->randomDigit()]);
            $base = $prefix . $middle . $suffix;

            // Add more characters if needed for minimum length
            while (strlen($base) < 4) {
                $base .= $this->faker->randomElement([$this->faker->randomLetter(), $this->faker->randomDigit()]);
            }
        }

        return $base;
    }
}
