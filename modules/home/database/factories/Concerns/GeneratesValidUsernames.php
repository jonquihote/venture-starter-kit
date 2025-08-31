<?php

namespace Venture\Home\Database\Factories\Concerns;

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
        // Start with a lowercase letter
        $username = $this->faker->randomElement(range('a', 'z'));

        // Determine length (4-16 characters total)
        $totalLength = $this->faker->numberBetween(4, 16);

        // Generate middle characters (need at least 1 more for ending)
        $middleLength = $totalLength - 2; // -1 for start, -1 for end

        $lastChar = $username[0]; // Track last character to avoid consecutive symbols

        for ($i = 0; $i < $middleLength; $i++) {
            // Choose from allowed characters
            $choices = ['letter', 'number'];

            // Only allow symbols if last char wasn't a symbol
            if (! in_array($lastChar, ['.', '_'])) {
                $choices[] = 'symbol';
            }

            $choice = $this->faker->randomElement($choices);

            switch ($choice) {
                case 'letter':
                    $char = $this->faker->randomElement(range('a', 'z'));

                    break;
                case 'number':
                    $char = (string) $this->faker->numberBetween(0, 9);

                    break;
                case 'symbol':
                    $char = $this->faker->randomElement(['.', '_']);

                    break;
            }

            $username .= $char;
            $lastChar = $char;
        }

        // Ensure it ends with a letter or number
        if ($this->faker->boolean()) {
            $username .= $this->faker->randomElement(range('a', 'z'));
        } else {
            $username .= (string) $this->faker->numberBetween(0, 9);
        }

        return $username;
    }
}
