<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;

describe('AccountCredential Model', function (): void {
    describe('Model Configuration', function (): void {
        it('has correct fillable fields', function (): void {
            $credential = new AccountCredential;

            expect($credential->getFillable())->toEqual([
                'account_id',
                'type',
                'value',
                'verified_at',
                'is_primary',
            ]);
        });

        it('uses HasFactory trait', function (): void {
            expect(in_array('Illuminate\Database\Eloquent\Factories\HasFactory', class_uses(AccountCredential::class)))
                ->toBeTrue();
        });

        it('has factory properly configured', function (): void {
            $credential = AccountCredential::factory()->email()->make();

            expect($credential)->toBeInstanceOf(AccountCredential::class);
            expect($credential->type)->toBeInstanceOf(AccountCredentialTypesEnum::class);
            expect($credential->value)->toBeString();
            expect($credential->account_id)->toBeInt();
        });
    });

    describe('Casts', function (): void {
        it('casts type to AccountCredentialTypesEnum', function (): void {
            $credential = AccountCredential::factory()->email()->create();

            expect($credential->type)->toBeInstanceOf(AccountCredentialTypesEnum::class);
            expect($credential->type)->toBe(AccountCredentialTypesEnum::Email);
        });

        it('casts verified_at to datetime', function (): void {
            $verifiedAt = now();
            $credential = AccountCredential::factory()->email()->verified()->create();

            expect($credential->verified_at)->toBeInstanceOf(Carbon::class);
            expect($credential->verified_at)->not->toBeNull();
        });

        it('handles null verified_at correctly', function (): void {
            $credential = AccountCredential::factory()->email()->create();

            expect($credential->verified_at)->toBeNull();
        });

        it('can serialize and deserialize type enum', function (): void {
            $credential = AccountCredential::factory()->username()->create();

            // Refresh from database to test serialization
            $credential->refresh();

            expect($credential->type)->toBeInstanceOf(AccountCredentialTypesEnum::class);
            expect($credential->type->value)->toBe('username');
        });
    });

    describe('Relationships', function (): void {
        it('account() method returns BelongsTo relationship', function (): void {
            $credential = new AccountCredential;
            $relationship = $credential->account();

            expect($relationship)->toBeInstanceOf(BelongsTo::class);
            expect($relationship->getRelated())->toBeInstanceOf(Account::class);
        });

        it('can access related account', function (): void {
            $account = Account::factory()->create(['name' => 'Test User']);
            $credential = AccountCredential::factory()->email('test@example.com')->create([
                'account_id' => $account->id,
            ]);

            $relatedAccount = $credential->account;

            expect($relatedAccount)->toBeInstanceOf(Account::class);
            expect($relatedAccount->id)->toBe($account->id);
            expect($relatedAccount->name)->toBe('Test User');
        });

        it('eager loads account relationship', function (): void {
            $account = Account::factory()->create();
            AccountCredential::factory()->email()->create([
                'account_id' => $account->id,
            ]);

            $credentials = AccountCredential::with('account')->get();

            expect($credentials->first()->relationLoaded('account'))->toBeTrue();
            expect($credentials->first()->account)->toBeInstanceOf(Account::class);
        });
    });

    describe('Database Table', function (): void {
        it('getTable() returns correct table name', function (): void {
            $credential = new AccountCredential;

            expect($credential->getTable())->toBe('alpha_account_credentials');
            expect($credential->getTable())->toBe(MigrationsEnum::AccountCredentials->table());
        });

        it('uses correct table for database operations', function (): void {
            $credential = AccountCredential::factory()->email()->create();

            // Verify the record exists in the correct table using Laravel's assertDatabaseHas
            assertDatabaseHas('alpha_account_credentials', [
                'id' => $credential->id,
                'type' => AccountCredentialTypesEnum::Email->value,
                'value' => $credential->value,
            ]);
        });
    });

    describe('Primary Designation Constraints', function (): void {
        it('allows only one primary credential per type per account', function (): void {
            $account = Account::factory()->create();

            // Create first primary email credential
            AccountCredential::factory()->email('primary@example.com')->create([
                'account_id' => $account->id,
                'is_primary' => true,
            ]);

            // Verify database constraint prevents duplicate primary credentials
            assertDatabaseHas('alpha_account_credentials', [
                'account_id' => $account->id,
                'type' => AccountCredentialTypesEnum::Email->value,
                'is_primary' => true,
            ]);

            // Attempting to create another primary email credential should fail
            expect(function () use ($account): void {
                AccountCredential::factory()->email('another@example.com')->create([
                    'account_id' => $account->id,
                    'is_primary' => true,
                ]);
            })->toThrow(QueryException::class);
        });

        it('prevents multiple credentials with same account_id, type, and is_primary combination', function (): void {
            $account = Account::factory()->create();

            // Create first secondary email credential
            AccountCredential::factory()->email('email1@example.com')->secondary()->create([
                'account_id' => $account->id,
            ]);

            // Attempting to create another non-primary email credential should fail due to unique constraint
            expect(function () use ($account): void {
                AccountCredential::factory()->email('email2@example.com')->secondary()->create([
                    'account_id' => $account->id,
                ]);
            })->toThrow(QueryException::class);
        });

        it('allows different accounts to have primary credentials of same type', function (): void {
            $account1 = Account::factory()->create();
            $account2 = Account::factory()->create();

            $credential1 = AccountCredential::factory()->email('user1@example.com')->create([
                'account_id' => $account1->id,
                'is_primary' => true,
            ]);

            $credential2 = AccountCredential::factory()->email('user2@example.com')->create([
                'account_id' => $account2->id,
                'is_primary' => true,
            ]);

            expect($credential1->exists)->toBeTrue();
            expect($credential2->exists)->toBeTrue();
        });

        it('allows same account to have primary credentials of different types', function (): void {
            $account = Account::factory()->create();

            $emailCredential = AccountCredential::factory()->email('user@example.com')->create([
                'account_id' => $account->id,
                'is_primary' => true,
            ]);

            $usernameCredential = AccountCredential::factory()->username('username123')->create([
                'account_id' => $account->id,
                'is_primary' => true,
            ]);

            expect($emailCredential->exists)->toBeTrue();
            expect($usernameCredential->exists)->toBeTrue();
        });
    });

    describe('Value Uniqueness Constraints', function (): void {
        it('enforces unique values across all credentials', function (): void {
            AccountCredential::factory()->email('unique@example.com')->create();

            // Attempting to create another credential with same value should fail
            expect(function (): void {
                AccountCredential::factory()->email('unique@example.com')->create();
            })->toThrow(QueryException::class);
        });

        it('enforces uniqueness even across different credential types', function (): void {
            AccountCredential::factory()->email('shared-value')->create();

            // Attempting to use same value for username should fail
            expect(function (): void {
                AccountCredential::factory()->username('shared-value')->create();
            })->toThrow(QueryException::class);
        });
    });

    describe('Enum Integration', function (): void {
        it('works with all AccountCredentialTypesEnum values', function (): void {
            $account = Account::factory()->create();

            // Test Email type
            $emailCredential = AccountCredential::factory()->email('test@example.com')->create([
                'account_id' => $account->id,
            ]);

            expect($emailCredential->type)->toBe(AccountCredentialTypesEnum::Email);
            expect($emailCredential->type->value)->toBe('email');

            // Test Username type
            $usernameCredential = AccountCredential::factory()->username('testuser')->create([
                'account_id' => $account->id,
            ]);

            expect($usernameCredential->type)->toBe(AccountCredentialTypesEnum::Username);
            expect($usernameCredential->type->value)->toBe('username');
        });

        it('can query by enum type', function (): void {
            // Clear any existing credentials to ensure clean test
            AccountCredential::query()->truncate();

            $account = Account::factory()->create();

            AccountCredential::factory()->email('email@example.com')->create([
                'account_id' => $account->id,
            ]);

            AccountCredential::factory()->username('username123')->create([
                'account_id' => $account->id,
            ]);

            $emailCredentials = AccountCredential::where('type', AccountCredentialTypesEnum::Email)->get();
            $usernameCredentials = AccountCredential::where('type', AccountCredentialTypesEnum::Username)->get();

            expect($emailCredentials)->toHaveCount(1);
            expect($usernameCredentials)->toHaveCount(1);
            expect($emailCredentials->first()->value)->toBe('email@example.com');
            expect($usernameCredentials->first()->value)->toBe('username123');
        });
    });
});
