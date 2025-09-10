<?php

declare(strict_types=1);

use Venture\Alpha\Rules\ValidUsername;

describe('ValidUsername Rule', function (): void {

    describe('Valid Usernames', function (): void {
        it('accepts usernames with lowercase letters only', function (): void {
            $validator = validator(['username' => 'john'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts usernames with lowercase letters and numbers', function (): void {
            $validator = validator(['username' => 'user123'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts usernames with single dots', function (): void {
            $validator = validator(['username' => 'john.doe'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts usernames with single underscores', function (): void {
            $validator = validator(['username' => 'john_doe'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts usernames with mixed dots, underscores, and numbers', function (): void {
            $validator = validator(['username' => 'user_123.test'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts minimum length username (4 characters)', function (): void {
            $validator = validator(['username' => 'john'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts maximum length username (16 characters)', function (): void {
            $validator = validator(['username' => 'verylongusername'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });

        it('accepts usernames ending with numbers', function (): void {
            $validator = validator(['username' => 'user42'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        });
    });

    describe('Length Validation', function (): void {
        it('rejects usernames shorter than 4 characters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.length'));
        })->with([
            'a',
            'ab',
            'abc',
        ]);

        it('rejects usernames longer than 16 characters', function (): void {
            $validator = validator(['username' => 'verylongusernamethatismorethan16chars'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.length'));
        });

        it('rejects non-string values for length validation', function (): void {
            $validator = validator(['username' => 123456], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.length'));
        });
    });

    describe('Start Character Validation', function (): void {
        it('rejects usernames starting with uppercase letters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.start_letter'));
        })->with([
            'John',
            'USER123',
            'Test_user',
        ]);

        it('rejects usernames starting with numbers', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.start_letter'));
        })->with([
            '1user',
            '9test',
            '0admin',
        ]);

        it('rejects usernames starting with special characters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.start_letter'));
        })->with([
            '_user',
            '.test',
            '-admin',
            '@user',
        ]);
    });

    describe('End Character Validation', function (): void {
        it('rejects usernames ending with dots', function (): void {
            $validator = validator(['username' => 'user.'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.end_letter_number'));
        });

        it('rejects usernames ending with underscores', function (): void {
            $validator = validator(['username' => 'user_'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.end_letter_number'));
        });

        it('rejects usernames ending with hyphens', function (): void {
            $validator = validator(['username' => 'user-'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.end_letter_number'));
        });

        it('rejects usernames ending with special characters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.end_letter_number'));
        })->with([
            'user@',
            'test#',
            'admin$',
            'name%',
        ]);
    });

    describe('Allowed Characters Validation', function (): void {
        it('rejects usernames with uppercase letters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.allowed_chars'));
        })->with([
            'userName',
            'testUser',
            'adminPanel',
        ]);

        it('rejects usernames with special characters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.allowed_chars'));
        })->with([
            'user@domain',
            'test#hash',
            'admin$money',
            'name%percent',
            'user&and',
            'test*star',
            'admin+plus',
            'user=equal',
            'test-dash',
            'admin!exclaim',
            'user?question',
            'test<less',
            'admin>greater',
            'user,comma',
            'test;semicolon',
            'admin:colon',
            "user'quote",
            'test"doublequote',
            'admin\\backslash',
            'user|pipe',
            'test~tilde',
            'admin`backtick',
            'user(paren',
            'test)paren',
            'admin[bracket',
            'user]bracket',
            'test{brace',
            'admin}brace',
        ]);

        it('rejects usernames with spaces', function (): void {
            $validator = validator(['username' => 'user name'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.allowed_chars'));
        });

        it('rejects usernames with international characters', function (string $username, string $expectedErrorKey): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__("alpha::rules/valid_username.{$expectedErrorKey}"));
        })->with([
            ['josé', 'end_letter_number'], // é is not in [a-z0-9] for end check
            ['müller', 'allowed_chars'],   // ü is not in [a-z0-9._]
            ['françois', 'allowed_chars'], // ç is not in [a-z0-9._]
            ['åke', 'start_letter'],       // å is not in [a-z] for start check
            ['øyvind', 'start_letter'],    // ø is not in [a-z] for start check
        ]);
    });

    describe('Consecutive Characters Validation', function (): void {
        it('rejects usernames with consecutive dots', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.no_consecutive'));
        })->with([
            'user..name',
            'test...admin',
            'john..doe',
        ]);

        it('rejects usernames with consecutive underscores', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.no_consecutive'));
        })->with([
            'user__name',
            'test___admin',
            'john__doe',
        ]);

        it('rejects usernames with mixed consecutive special characters', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.no_consecutive'));
        })->with([
            'user._name',
            'test_.admin',
            'john._doe',
        ]);

        it('rejects usernames with multiple consecutive patterns', function (): void {
            $validator = validator(['username' => 'user..name__test'], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__('alpha::rules/valid_username.no_consecutive'));
        });
    });

    describe('Real World Examples', function (): void {
        it('accepts common valid username patterns', function (string $username): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeTrue();
        })->with([
            'john',
            'jane_doe',
            'user123',
            'admin_2024',
            'test.user',
            'dev_team_01',
            'customer.1',
            'support_agent',
            'power_user99',
            'guest_123',
            'moderator.5',
            'beta_tester',
        ]);
    });

    describe('Invalid Pattern Tests', function (): void {
        it('rejects common invalid username patterns', function (string $username, string $errorKey): void {
            $validator = validator(['username' => $username], ['username' => new ValidUsername]);

            expect($validator->passes())->toBeFalse();
            expect($validator->errors()->first('username'))->toBe(__("alpha::rules/valid_username.{$errorKey}"));
        })->with([
            // Too short
            ['usr', 'length'],
            ['xy', 'length'],
            // Too long
            ['verylongusernamethatismorethan16characters', 'length'],
            // Bad start
            ['1user', 'start_letter'],
            ['_admin', 'start_letter'],
            ['.test', 'start_letter'],
            ['User', 'start_letter'],
            // Bad end
            ['user_', 'end_letter_number'],
            ['admin.', 'end_letter_number'],
            // Bad characters
            ['user@domain', 'allowed_chars'],
            ['test-user', 'allowed_chars'],
            ['admin space', 'allowed_chars'],
            // Consecutive
            ['user..name', 'no_consecutive'],
            ['test__admin', 'no_consecutive'],
        ]);
    });
});
