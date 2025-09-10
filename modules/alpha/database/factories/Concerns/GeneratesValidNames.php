<?php

namespace Venture\Alpha\Database\Factories\Concerns;

trait GeneratesValidNames
{
    /**
     * Generate a name that complies with ValidName rule.
     * - Only ASCII letters (uppercase, lowercase) and regular spaces
     * - Must contain at least one letter (not just spaces)
     * - Converts unicode characters to ASCII equivalents
     */
    protected function generateValidName(): string
    {
        // Generate base name from faker
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $name = "{$firstName} {$lastName}";

        // Convert unicode to ASCII
        $name = $this->convertUnicodeToAscii($name);

        // Clean the name to only contain allowed characters
        $name = preg_replace('/[^A-Za-z ]/', '', $name);

        // Remove extra spaces and trim
        $name = preg_replace('/\s+/', ' ', trim($name));

        // Ensure it contains at least one letter
        if (empty($name) || ! preg_match('/[A-Za-z]/', $name)) {
            // Fallback to a guaranteed valid name
            $name = 'John Doe';
        }

        return $name;
    }

    /**
     * Convert unicode characters to ASCII equivalents.
     */
    private function convertUnicodeToAscii(string $string): string
    {
        // Use Transliterator if available (best option)
        if (class_exists('Transliterator')) {
            $transliterator = \Transliterator::createFromRules(
                ':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;'
            );

            if ($transliterator !== null) {
                $result = $transliterator->transliterate($string);
                if ($result !== false) {
                    return $result;
                }
            }
        }

        // Fallback to iconv if Transliterator is not available
        if (function_exists('iconv')) {
            $result = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
            if ($result !== false) {
                return $result;
            }
        }

        // Manual fallback for common accented characters
        $replacements = [
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ñ' => 'N', 'ñ' => 'n',
            'Ç' => 'C', 'ç' => 'c',
            'Ý' => 'Y', 'ý' => 'y', 'ÿ' => 'y',
        ];

        return strtr($string, $replacements);
    }
}
