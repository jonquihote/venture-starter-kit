<?php

declare(strict_types=1);

use Venture\Alpha\Rules\ValidName;

describe('ValidName Rule', function (): void {

    describe('Valid Names', function (): void {
        it('accepts names with only letters', function (): void {
            $validator = validator(['name' => 'John', [new ValidName]]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts names with letters and spaces', function (): void {
            $validator = validator(['name' => 'John Doe', [new ValidName]]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts names with multiple words', function (): void {
            $validator = validator(['name' => 'Mary Jane Watson', [new ValidName]]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts single letter names', function (): void {
            $validator = validator(['name' => 'X', [new ValidName]]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts names with mixed case', function (): void {
            $validator = validator(['name' => 'McDONALD', [new ValidName]]);

            expect($validator->passes())->toBeTrue();
        });
    });

    describe('Invalid Names', function (): void {
        it('rejects names with non-ASCII characters', function (): void {
            $validator = validator(['name' => 'José María'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with numbers', function (): void {
            $validator = validator(['name' => 'John123'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with special characters', function (): void {
            $validator = validator(['name' => 'John@Doe'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with underscores', function (): void {
            $validator = validator(['name' => 'John_Doe'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with hyphens', function (): void {
            $validator = validator(['name' => 'Mary-Jane'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with tabs', function (): void {
            $validator = validator(['name' => "John\tDoe"], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with newlines', function (): void {
            $validator = validator(['name' => "John\nDoe"], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects non-string values', function (): void {
            $validator = validator(['name' => 123], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects array values', function (): void {
            $validator = validator(['name' => ['John', 'Doe']], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });
    });

    describe('International Characters', function (): void {
        it('rejects names with accented characters', function (string $name): void {
            $validator = validator(['name' => $name], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        })->with([
            'José',
            'María',
            'François',
            'Müller',
            'Åke',
            'Øyvind',
            'Łukasz',
            'Žofia',
        ]);

        it('rejects names with emoji', function (): void {
            $validator = validator(['name' => 'John 😀'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with Chinese characters', function (): void {
            $validator = validator(['name' => '王小明'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });

        it('rejects names with Arabic characters', function (): void {
            $validator = validator(['name' => 'محمد'], ['name' => new ValidName]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('name'))->toBe(__('alpha::rules/valid_name.invalid_characters'));
        });
    });
});
