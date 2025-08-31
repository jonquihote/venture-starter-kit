<?php

declare(strict_types=1);

use Venture\Home\Rules\ValidName;

test('name validation accepts valid names', function (string $name): void {
    $rule = new ValidName;
    $failed = false;
    $fail = function ($message) use (&$failed): void {
        $failed = true;
    };

    $rule->validate('name', $name, $fail);

    expect($failed)->toBeFalse();
})->with([
    'simple name' => 'John Doe',
    'single name' => 'John',
    'multiple spaces' => 'John    Doe',
    'unicode letters' => 'José María',
    'accented characters' => 'François Müller',
    'cyrillic' => 'Владимир Путин',
    'arabic' => 'محمد العربي',
    'chinese' => '李小明',
    'japanese' => '田中太郎',
    'special unicode marks' => 'Naïve Café',
    'long name with spaces' => 'Jean Baptiste Pierre François Marie de la Salle',
    'name with combining marks' => 'José Martín',
]);

test('name validation rejects invalid names', function (string $name): void {
    $rule = new ValidName;
    $failed = false;
    $fail = function ($message) use (&$failed): void {
        $failed = true;
    };

    $rule->validate('name', $name, $fail);

    expect($failed)->toBeTrue();
})->with([
    'contains numbers' => 'John Doe 123',
    'starts with number' => '123 John',
    'contains special chars' => 'John@Doe',
    'contains dash' => 'Jean-Baptiste',
    'contains underscore' => 'John_Doe',
    'contains dot' => 'John.Doe',
    'contains comma' => 'Doe, John',
    'name with title' => 'Mrs. Magdalena Bernier',
    'name with initials' => 'J. R. R. Tolkien',
    'contains apostrophe' => "O'Connor",
    'contains parentheses' => 'John (Johnny) Doe',
    'contains hashtag' => 'John #1',
    'contains emoji' => 'John 😊',
    'only numbers' => '12345',
    'only special chars' => '@#$%',
    'empty spaces only' => '   ',
    'newline character' => "John\nDoe",
    'tab character' => "John\tDoe",
]);

test('name validation skips empty values', function (): void {
    $rule = new ValidName;
    $failed = false;
    $fail = function ($message) use (&$failed): void {
        $failed = true;
    };

    $rule->validate('name', '', $fail);
    $rule->validate('name', null, $fail);

    expect($failed)->toBeFalse();
});
