<?php

declare(strict_types=1);

use Venture\Home\Rules\ValidUsername;

test('username validation accepts valid usernames', function (string $username): void {
    $rule = new ValidUsername;
    $validationPassed = true;
    $fail = function ($message) use (&$validationPassed): void {
        $validationPassed = false;

        throw new Exception($message);
    };

    $rule->validate('username', $username, $fail);

    expect($validationPassed)->toBeTrue();
})->with([
    'basic lowercase' => 'john',
    'lowercase with numbers' => 'user123',
    'with dots in middle' => 'john.doe1',
    'with underscores in middle' => 'alice_smith2',
    'mixed valid' => 'user.2024_test9',
    'min length (4 chars)' => 'abc1',
    'max length (16 chars)' => 'abcdefghijklmno1',
    'ends with number' => 'alice2024',
    'ends with letter' => 'johndoe',
    'complex valid' => 'a1.b2_c3',
    'dots in middle only' => 'a.b.c1',
    'underscores in middle only' => 'user_name_2',
    'complex valid pattern' => 'test.user2024',
    'exactly 4 characters' => 'abc1',
    'exactly 16 characters' => 'abcdefghijklmno1',
]);

test('username validation rejects invalid usernames', function (string $username): void {
    $rule = new ValidUsername;
    $failed = false;
    $fail = function ($message) use (&$failed): void {
        $failed = true;
    };

    $rule->validate('username', $username, $fail);

    expect($failed)->toBeTrue();
})->with([
    // Case violations
    'contains uppercase' => 'John',
    'all uppercase' => 'USER',
    'mixed case' => 'JohnDoe',

    // Starting character violations
    'starts with number' => '1user',
    'starts with dot' => '.john',
    'starts with underscore' => '_alice',

    // Ending character violations
    'ends with dot' => 'john.',
    'ends with underscore' => 'user_',
    'ends with multiple dots' => 'user..',

    // Length violations
    'too short (3 chars)' => 'abc',
    'too short (1 char)' => 'a',
    'too long (17 chars)' => 'abcdefghijklmnopq',

    // Invalid characters
    'contains dash' => 'john-doe',
    'contains space' => 'john doe',
    'contains @' => 'john@doe',
    'contains #' => 'user#123',
    'contains $' => 'test$user',

    // Double symbols
    'multiple dots in middle' => 'a..b1',
    'multiple underscores in middle' => 'a__b1',
    'dot underscore combo' => 'a._b1',
    'underscore dot combo' => 'a_.b1',
    'triple dots' => 'a...b1',
    'mixed consecutive symbols' => 'user._name',
    'double symbols at start boundary' => 'ab..c1',
    'double symbols at end boundary' => 'abc..1',
    'ends with underscore and dot' => 'test_.',
    'starts and ends wrong' => '_test.',
]);

test('username validation skips empty values', function (): void {
    $rule = new ValidUsername;
    $validationPassed = true;
    $fail = function ($message) use (&$validationPassed): void {
        $validationPassed = false;

        throw new Exception($message);
    };

    $rule->validate('username', '', $fail);
    $rule->validate('username', null, $fail);

    expect($validationPassed)->toBeTrue();
});

test('username validation provides specific error messages', function (): void {
    $rule = new ValidUsername;

    // Test start letter error
    $messages = [];
    $rule->validate('username', '1user', function ($message) use (&$messages): void {
        $messages[] = $message;
    });

    // Test end character error
    $rule->validate('username', 'user_', function ($message) use (&$messages): void {
        $messages[] = $message;
    });

    // Test allowed characters error
    $rule->validate('username', 'user@test', function ($message) use (&$messages): void {
        $messages[] = $message;
    });

    // Test consecutive symbols error
    $rule->validate('username', 'user..test', function ($message) use (&$messages): void {
        $messages[] = $message;
    });

    expect($messages)->toHaveCount(4);
});
