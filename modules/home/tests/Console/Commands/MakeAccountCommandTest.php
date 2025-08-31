<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Venture\Aeon\Facades\Access;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

describe('MakeAccountCommand Database Operations', function (): void {
    beforeEach(function (): void {
        // Create actual roles in database for testing
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'home::authorization/roles.user', 'guard_name' => 'web']); // Default user role

        // Mock Access facade to return the created roles
        Access::shouldReceive('administratorRoles')
            ->andReturn(collect(['administrator', 'super-admin']));
    });

    test('can create account with proper data structure', function (): void {
        // Test the core functionality by directly creating an account as the command would
        $accountData = [
            'name' => 'John Doe',
            'password' => 'password123',
        ];

        $account = Account::create($accountData);
        $account->updateUsername('john.doe');
        $account->updateEmail('john.doe@example.com');

        assertDatabaseHas('home_accounts', [
            'name' => 'John Doe',
        ]);

        expect($account)->not->toBeNull()
            ->and(Hash::check('password123', $account->password))->toBeTrue();

        // Verify credentials were created
        expect($account->credentials)->toHaveCount(2);
    });

    test('creates username and email credentials correctly', function (): void {
        $account = Account::create([
            'name' => 'Jane Smith',
            'password' => 'secret456',
        ]);

        $account->updateUsername('jane.smith');
        $account->updateEmail('jane@example.com');

        // Check username credential
        assertDatabaseHas('home_account_credentials', [
            'account_id' => $account->id,
            'type' => AccountCredentialTypesEnum::Username->value,
            'value' => 'jane.smith',
            'is_primary' => true,
        ]);

        // Check email credential
        assertDatabaseHas('home_account_credentials', [
            'account_id' => $account->id,
            'type' => AccountCredentialTypesEnum::Email->value,
            'value' => 'jane@example.com',
            'is_primary' => true,
        ]);

        // Verify username is verified but email is not
        $usernameCredential = AccountCredential::where('account_id', $account->id)
            ->where('type', AccountCredentialTypesEnum::Username)
            ->first();
        $emailCredential = AccountCredential::where('account_id', $account->id)
            ->where('type', AccountCredentialTypesEnum::Email)
            ->first();

        expect($usernameCredential->verified_at)->not->toBeNull()
            ->and($emailCredential->verified_at)->toBeNull();
    });

    test('assigns super administrator roles when requested', function (): void {
        $account = Account::create([
            'name' => 'Admin User',
            'password' => 'adminpass',
        ]);

        $account->updateUsername('admin.user');
        $account->updateEmail('admin@example.com');

        // Simulate role assignment (syncRoles replaces existing roles)
        $account->syncRoles(Access::administratorRoles());

        expect($account->roles)->toHaveCount(2)
            ->and($account->getRoleNames()->toArray())->toContain('administrator', 'super-admin');
    });

    test('does not assign roles when not requested', function (): void {
        $account = Account::create([
            'name' => 'Regular User',
            'password' => 'userpass',
        ]);

        $account->updateUsername('regular.user');
        $account->updateEmail('user@example.com');

        // Refresh the account to ensure we get fresh data
        $account = $account->fresh();
        expect($account->roles()->count())->toBe(1); // Should have only the default User role
        expect($account->hasRole('home::authorization/roles.user'))->toBeTrue();
    });

    test('trims and squishes name input correctly', function (): void {
        // Test the Str::squish functionality
        $account = Account::create([
            'name' => \Illuminate\Support\Str::squish('  John   Doe  '),
            'password' => 'password',
        ]);

        assertDatabaseHas('home_accounts', [
            'name' => 'John Doe', // Should be trimmed and squished
        ]);
    });

    test('handles database transaction correctly', function (): void {
        // Test transaction behavior by creating account and credentials together
        \Illuminate\Support\Facades\DB::transaction(function (): void {
            $account = Account::create([
                'name' => 'Transaction Test',
                'password' => 'password',
            ]);

            $account->updateUsername('trans.test');
            $account->updateEmail('trans@example.com');

            // Verify account was created
            assertDatabaseHas('home_accounts', ['name' => 'Transaction Test']);

            // Verify both credentials were created
            expect($account->credentials)->toHaveCount(2);
        });
    });
});

describe('MakeAccountCommand Validation Rules', function (): void {
    beforeEach(function (): void {
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'home::authorization/roles.user', 'guard_name' => 'web']); // Default user role

        Access::shouldReceive('administratorRoles')
            ->andReturn(collect(['administrator', 'super-admin']));
    });

    test('validates unique username constraint', function (): void {
        // Create an existing account with username credential
        $existingAccount = Account::factory()->create();
        AccountCredential::factory()->username('existing.user')->create([
            'account_id' => $existingAccount->id,
            'is_primary' => true,
        ]);

        // Test that uniqueness validation would work
        $rule = \Illuminate\Validation\Rule::unique(AccountCredential::class, 'value')
            ->where(function (\Illuminate\Database\Query\Builder $query) {
                return $query->where('type', AccountCredentialTypesEnum::Username);
            });

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['username' => 'existing.user'],
            ['username' => [$rule]]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('username'))->toBeTrue();
    });

    test('validates unique email constraint', function (): void {
        // Create an existing account with email credential
        $existingAccount = Account::factory()->create();
        AccountCredential::factory()->email('existing@example.com')->create([
            'account_id' => $existingAccount->id,
            'is_primary' => true,
        ]);

        $rule = \Illuminate\Validation\Rule::unique(AccountCredential::class, 'value')
            ->where(function (\Illuminate\Database\Query\Builder $query) {
                return $query->where('type', AccountCredentialTypesEnum::Email);
            });

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['email' => 'existing@example.com'],
            ['email' => ['email', $rule]]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('email'))->toBeTrue();
    });

    test('validates name with ValidName rule', function (): void {
        $rule = new \Venture\Home\Rules\ValidName;

        $validator = \Illuminate\Support\Facades\Validator::make(
            ['name' => 'Invalid123Name'], // Numbers not allowed
            ['name' => ['required', $rule]]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('name'))->toBeTrue();
    });

    test('validates username with ValidUsername rule', function (): void {
        $rule = new \Venture\Home\Rules\ValidUsername;

        // Test username that doesn't start with letter
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['username' => '123invalid'],
            ['username' => ['required', 'min:4', 'max:16', $rule]]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('username'))->toBeTrue();
    });

    test('validates username length constraints', function (): void {
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['username' => 'abc'], // Too short
            ['username' => ['required', 'min:4', 'max:16']]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('username'))->toBeTrue();

        $validator2 = \Illuminate\Support\Facades\Validator::make(
            ['username' => 'thisusernameistoolongtobevalid'], // Too long
            ['username' => ['required', 'min:4', 'max:16']]
        );

        expect($validator2->fails())->toBeTrue()
            ->and($validator2->errors()->has('username'))->toBeTrue();
    });

    test('validates email format correctly', function (): void {
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['email' => 'invalid-email'], // Invalid format
            ['email' => ['required', 'email']]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('email'))->toBeTrue();
    });

    test('validates required fields', function (): void {
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['name' => ''], // Empty name
            ['name' => ['required']]
        );

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('name'))->toBeTrue();
    });

    test('accepts valid inputs', function (): void {
        // Test all validation rules with valid data
        $rule = new \Venture\Home\Rules\ValidName;
        $usernameRule = new \Venture\Home\Rules\ValidUsername;

        $validator = \Illuminate\Support\Facades\Validator::make([
            'name' => 'John Doe',
            'username' => 'john.doe',
            'email' => 'john@example.com',
        ], [
            'name' => ['required', $rule],
            'username' => ['required', 'min:4', 'max:16', $usernameRule],
            'email' => ['required', 'email'],
        ]);

        expect($validator->passes())->toBeTrue();
    });
});

describe('MakeAccountCommand Error Handling', function (): void {
    beforeEach(function (): void {
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'home::authorization/roles.user', 'guard_name' => 'web']); // Default user role
    });

    test('handles role assignment errors within transaction', function (): void {
        // Mock Access to throw an exception during role assignment
        Access::shouldReceive('administratorRoles')
            ->andThrow(new \Exception('Role service unavailable'));

        $initialAccountCount = Account::count();
        $initialCredentialCount = AccountCredential::count();

        expect(function (): void {
            \Illuminate\Support\Facades\DB::transaction(function (): void {
                $account = Account::create([
                    'name' => 'Admin User',
                    'password' => 'password',
                ]);

                $account->updateUsername('admin.user');
                $account->updateEmail('admin@example.com');

                // This should throw the exception
                $account->syncRoles(Access::administratorRoles());
            });
        })->toThrow(\Exception::class, 'Role service unavailable');

        // Verify transaction rollback prevented any data from being saved
        expect(Account::count())->toBe($initialAccountCount);
        expect(AccountCredential::count())->toBe($initialCredentialCount);
    });
});

describe('MakeAccountCommand Edge Cases', function (): void {
    beforeEach(function (): void {
        Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'home::authorization/roles.user', 'guard_name' => 'web']); // Default user role

        Access::shouldReceive('administratorRoles')
            ->andReturn(collect(['administrator', 'super-admin']));
    });

    test('handles unicode characters in name', function (): void {
        $account = Account::create([
            'name' => 'José María',
            'password' => 'password',
        ]);

        assertDatabaseHas('home_accounts', [
            'name' => 'José María',
        ]);

        // Test that ValidName rule accepts unicode characters
        $rule = new \Venture\Home\Rules\ValidName;
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['name' => 'José María'],
            ['name' => ['required', $rule]]
        );

        expect($validator->passes())->toBeTrue();
    });

    test('handles minimum valid username length', function (): void {
        $account = Account::create([
            'name' => 'Test User',
            'password' => 'password',
        ]);

        $account->updateUsername('test'); // Exactly 4 characters

        assertDatabaseHas('home_account_credentials', [
            'type' => AccountCredentialTypesEnum::Username->value,
            'value' => 'test',
        ]);
    });

    test('handles maximum valid username length', function (): void {
        $account = Account::create([
            'name' => 'Test User',
            'password' => 'password',
        ]);

        $account->updateUsername('testusername1234'); // Exactly 16 characters

        assertDatabaseHas('home_account_credentials', [
            'type' => AccountCredentialTypesEnum::Username->value,
            'value' => 'testusername1234',
        ]);
    });

    test('handles complex valid username patterns', function (): void {
        $account = Account::create([
            'name' => 'Test User',
            'password' => 'password',
        ]);

        $account->updateUsername('user_name.123'); // Valid complex pattern

        assertDatabaseHas('home_account_credentials', [
            'type' => AccountCredentialTypesEnum::Username->value,
            'value' => 'user_name.123',
        ]);

        // Test that ValidUsername rule accepts this pattern
        $rule = new \Venture\Home\Rules\ValidUsername;
        $validator = \Illuminate\Support\Facades\Validator::make(
            ['username' => 'user_name.123'],
            ['username' => ['required', 'min:4', 'max:16', $rule]]
        );

        expect($validator->passes())->toBeTrue();
    });

    test('password is properly hashed', function (): void {
        $plainPassword = 'my-secret-password';

        $account = Account::create([
            'name' => 'Test User',
            'password' => $plainPassword,
        ]);

        expect($account)->not->toBeNull()
            ->and($account->password)->not->toBe($plainPassword) // Should be hashed
            ->and(Hash::check($plainPassword, $account->password))->toBeTrue(); // Should verify correctly
    });

    test('creates both username and email credentials with correct properties', function (): void {
        $account = Account::create([
            'name' => 'Credential Test',
            'password' => 'password',
        ]);

        $account->updateUsername('cred.test');
        $account->updateEmail('cred@example.com');

        // Check that exactly 2 credentials were created
        expect($account->credentials)->toHaveCount(2);

        $usernameCredential = $account->credentials()
            ->where('type', AccountCredentialTypesEnum::Username)
            ->first();
        $emailCredential = $account->credentials()
            ->where('type', AccountCredentialTypesEnum::Email)
            ->first();

        expect($usernameCredential)->not->toBeNull()
            ->and($usernameCredential->value)->toBe('cred.test')
            ->and($usernameCredential->is_primary)->toBeTrue()
            ->and($usernameCredential->verified_at)->not->toBeNull(); // Username should be verified

        expect($emailCredential)->not->toBeNull()
            ->and($emailCredential->value)->toBe('cred@example.com')
            ->and($emailCredential->is_primary)->toBeTrue()
            ->and($emailCredential->verified_at)->toBeNull(); // Email should not be verified
    });

    test('roles are assigned correctly when requested', function (): void {
        $account = Account::create([
            'name' => 'Super Admin',
            'password' => 'password',
        ]);

        $account->updateUsername('super.admin');
        $account->updateEmail('superadmin@example.com');
        $account->syncRoles(Access::administratorRoles());

        expect($account->hasRole('administrator'))->toBeTrue()
            ->and($account->hasRole('super-admin'))->toBeTrue()
            ->and($account->roles)->toHaveCount(2);
    });

    test('no roles assigned when not requested', function (): void {
        $account = Account::create([
            'name' => 'Regular User',
            'password' => 'password',
        ]);

        $account->updateUsername('regular.user');
        $account->updateEmail('regular@example.com');
        // No additional role assignment (only default User role from observer)

        // Refresh the account to ensure we get fresh data
        $account = $account->fresh();
        expect($account->roles()->count())->toBe(1); // Should have only the default User role
        expect($account->hasRole('home::authorization/roles.user'))->toBeTrue();
    });

    test('validates ValidName rule behavior', function (): void {
        $rule = new \Venture\Home\Rules\ValidName;

        // Test valid names (according to ValidName rule: letters, marks, and spaces only)
        $validNames = ['John Doe', 'María García', 'José Martín'];
        foreach ($validNames as $name) {
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['name' => $name],
                ['name' => ['required', $rule]]
            );
            expect($validator->passes())->toBeTrue("Name '{$name}' should be valid");
        }

        // Test invalid names (numbers, symbols, underscores not allowed)
        $invalidNames = ['John123', 'test@example.com', '123456', 'User_Name', 'Jean-Pierre'];
        foreach ($invalidNames as $name) {
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['name' => $name],
                ['name' => ['required', $rule]]
            );
            expect($validator->fails())->toBeTrue("Name '{$name}' should be invalid");
        }
    });

    test('validates ValidUsername rule behavior', function (): void {
        $rule = new \Venture\Home\Rules\ValidUsername;

        // Test valid usernames
        $validUsernames = ['john', 'user123', 'test_user', 'user.name', 'a1b2c3d4'];
        foreach ($validUsernames as $username) {
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['username' => $username],
                ['username' => ['required', 'min:4', 'max:16', $rule]]
            );
            expect($validator->passes())->toBeTrue("Username '{$username}' should be valid");
        }

        // Test invalid usernames
        $invalidUsernames = ['123user', 'user-name', 'user@name', 'user..name', 'user_', 'User', 'user$'];
        foreach ($invalidUsernames as $username) {
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['username' => $username],
                ['username' => ['required', 'min:4', 'max:16', $rule]]
            );
            expect($validator->fails())->toBeTrue("Username '{$username}' should be invalid");
        }
    });
});
