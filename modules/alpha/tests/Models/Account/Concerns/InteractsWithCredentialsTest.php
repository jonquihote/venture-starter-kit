<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;

describe('InteractsWithCredentials Trait', function (): void {
    beforeEach(function (): void {
        $this->account = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();
    });

    describe('Relationship Methods', function (): void {
        it('credentials() returns HasMany relationship', function (): void {
            $relationship = $this->account->credentials();

            expect($relationship)->toBeInstanceOf(HasMany::class);
            expect($relationship->getRelated())->toBeInstanceOf(AccountCredential::class);
            expect($this->account->credentials->count())->toBe(2);
        });

        it('email() returns primary email credential', function (): void {
            $relationship = $this->account->email();

            expect($relationship)->toBeInstanceOf(HasOne::class);
            expect($this->account->email)->toBeInstanceOf(AccountCredential::class);
            expect($this->account->email->type)->toBe(AccountCredentialTypesEnum::Email);
            expect($this->account->email->is_primary)->toBeTrue();
        });

        it('username() returns primary username credential', function (): void {
            $relationship = $this->account->username();

            expect($relationship)->toBeInstanceOf(HasOne::class);
            expect($this->account->username)->toBeInstanceOf(AccountCredential::class);
            expect($this->account->username->type)->toBe(AccountCredentialTypesEnum::Username);
            expect($this->account->username->is_primary)->toBeTrue();
        });
    });

    describe('Update Methods', function (): void {
        it('updateUsername() updates existing primary username credential', function (): void {
            $originalId = $this->account->username->id;
            $originalUsername = $this->account->username->value;
            $newUsername = 'newuser123';

            $credential = $this->account->updateUsername($newUsername);

            expect($credential)->toBeInstanceOf(AccountCredential::class);
            expect($credential->id)->toBe($originalId); // Same record, updated
            expect($credential->account_id)->toBe($this->account->id);
            expect($credential->type)->toBe(AccountCredentialTypesEnum::Username);
            expect($credential->value)->toBe($newUsername);
            expect($credential->is_primary)->toBeTrue();
            expect($credential->verified_at)->toBeInstanceOf(Carbon::class);

            // Verify only one username credential exists (updated, not duplicated)
            expect($this->account->credentials()
                ->where('type', AccountCredentialTypesEnum::Username)
                ->count())->toBe(1);

            assertDatabaseHas(AccountCredential::class, [
                'id' => $originalId,
                'account_id' => $this->account->id,
                'type' => AccountCredentialTypesEnum::Username,
                'value' => $newUsername,
                'is_primary' => true,
            ]);
        });

        it('updateUsername() for account without username creates new credential', function (): void {
            // Create account without username credential
            $accountWithoutUsername = Account::factory()
                ->has(AccountCredential::factory()->verified()->email(), 'credentials')
                ->create();

            $newUsername = 'newuser456';

            $credential = $accountWithoutUsername->updateUsername($newUsername);

            expect($credential)->toBeInstanceOf(AccountCredential::class);
            expect($credential->account_id)->toBe($accountWithoutUsername->id);
            expect($credential->type)->toBe(AccountCredentialTypesEnum::Username);
            expect($credential->value)->toBe($newUsername);
            expect($credential->is_primary)->toBeTrue();
            expect($credential->verified_at)->toBeInstanceOf(Carbon::class);

            assertDatabaseHas(AccountCredential::class, [
                'account_id' => $accountWithoutUsername->id,
                'type' => AccountCredentialTypesEnum::Username,
                'value' => $newUsername,
                'is_primary' => true,
            ]);
        });

        it('updateEmail() updates existing primary email credential and resets verification', function (): void {
            $originalId = $this->account->email->id;
            $originalEmail = $this->account->email->value;
            $newEmail = 'newemail@example.com';

            // Ensure original email is verified
            expect($this->account->email->verified_at)->not->toBeNull();

            $credential = $this->account->updateEmail($newEmail);

            expect($credential)->toBeInstanceOf(AccountCredential::class);
            expect($credential->id)->toBe($originalId); // Same record, updated
            expect($credential->account_id)->toBe($this->account->id);
            expect($credential->type)->toBe(AccountCredentialTypesEnum::Email);
            expect($credential->value)->toBe($newEmail);
            expect($credential->is_primary)->toBeTrue();
            expect($credential->verified_at)->toBeNull();

            // Verify only one email credential exists (updated, not duplicated)
            expect($this->account->credentials()
                ->where('type', AccountCredentialTypesEnum::Email)
                ->count())->toBe(1);

            assertDatabaseHas(AccountCredential::class, [
                'id' => $originalId,
                'account_id' => $this->account->id,
                'type' => AccountCredentialTypesEnum::Email,
                'value' => $newEmail,
                'is_primary' => true,
                'verified_at' => null,
            ]);
        });

        it('updateEmail() for account without email creates new credential', function (): void {
            // Create account without email credential
            $accountWithoutEmail = Account::factory()
                ->has(AccountCredential::factory()->verified()->username(), 'credentials')
                ->create();

            $newEmail = 'newemail@example.com';

            $credential = $accountWithoutEmail->updateEmail($newEmail);

            expect($credential)->toBeInstanceOf(AccountCredential::class);
            expect($credential->account_id)->toBe($accountWithoutEmail->id);
            expect($credential->type)->toBe(AccountCredentialTypesEnum::Email);
            expect($credential->value)->toBe($newEmail);
            expect($credential->is_primary)->toBeTrue();
            expect($credential->verified_at)->toBeNull();

            assertDatabaseHas(AccountCredential::class, [
                'account_id' => $accountWithoutEmail->id,
                'type' => AccountCredentialTypesEnum::Email,
                'value' => $newEmail,
                'is_primary' => true,
                'verified_at' => null,
            ]);
        });
    });

    describe('Query Scopes', function (): void {
        it('scopeWhereUsername() filters accounts by username value', function (): void {
            // Create additional accounts to test filtering
            $otherAccount = Account::factory()
                ->has(AccountCredential::factory()->verified()->username(), 'credentials')
                ->create();

            $targetUsername = $this->account->username->value;

            $results = Account::whereUsername($targetUsername)->get();

            expect($results->count())->toBe(1);
            expect($results->first()->id)->toBe($this->account->id);
            expect($results->pluck('id'))->not->toContain($otherAccount->id);
        });

        it('scopeWhereEmail() filters accounts by email value', function (): void {
            // Create additional accounts to test filtering
            $otherAccount = Account::factory()
                ->has(AccountCredential::factory()->verified()->email(), 'credentials')
                ->create();

            $targetEmail = $this->account->email->value;

            $results = Account::whereEmail($targetEmail)->get();

            expect($results->count())->toBe(1);
            expect($results->first()->id)->toBe($this->account->id);
            expect($results->pluck('id'))->not->toContain($otherAccount->id);
        });

        it('scopeWhereUsername() returns empty when username does not exist', function (): void {
            $results = Account::whereUsername('nonexistentuser')->get();

            expect($results->count())->toBe(0);
        });

        it('scopeWhereEmail() returns empty when email does not exist', function (): void {
            $results = Account::whereEmail('nonexistent@example.com')->get();

            expect($results->count())->toBe(0);
        });

        it('query scopes only match primary credentials', function (): void {
            // Create a secondary username credential
            AccountCredential::factory()->username('secondaryuser')->secondary()->create([
                'account_id' => $this->account->id,
            ]);

            $primaryUsername = $this->account->username->value;
            $secondaryUsername = 'secondaryuser';

            // Should find account by primary username
            expect(Account::whereUsername($primaryUsername)->count())->toBe(1);

            // Should not find account by secondary username
            expect(Account::whereUsername($secondaryUsername)->count())->toBe(0);
        });
    });
});
