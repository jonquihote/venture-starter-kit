<?php

use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Filament\Resources\Accounts\Pages\EditAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Primary account for editing tests
    $this->account = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Additional accounts for deletion and multi-account testing
    $this->accountA = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    $this->accountB = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Fresh test data for updates
    $this->data = Account::factory()->credentials()->make();
});

test('page can be rendered successfully with existing record', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->assertOk()
        ->assertSuccessful();
});

test('form is pre-populated with existing account data', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->assertSchemaStateSet([
            'name' => $this->account->name,
            'username.value' => $this->account->username->value,
            'email.value' => $this->account->email->value,
        ]);
});

test('password fields are hidden on edit page', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->assertFormFieldDoesNotExist('password')
        ->assertFormFieldDoesNotExist('password_confirmation');
});

test('can update account with valid data', function (): void {
    // Store original values for cleanup verification
    $username = $this->account->username->value;
    $email = $this->account->email->value;

    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

    // Verify account was updated in database
    assertDatabaseHas(Account::class, [
        'id' => $this->account->id,
        'name' => $this->data->name,
    ]);

    // Verify username credential was updated
    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Username,
        'value' => $this->data->username,
        'is_primary' => true,
    ]);

    // Verify email credential was updated
    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Email,
        'value' => $this->data->email,
        'is_primary' => true,
    ]);

    // Verify old values are gone
    assertDatabaseMissing(AccountCredential::class, [
        'account_id' => $this->account->id,
        'value' => $username,
    ]);

    assertDatabaseMissing(AccountCredential::class, [
        'account_id' => $this->account->id,
        'value' => $email,
    ]);
});

test('can update with same values (should work)', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->account->name,
            'username.value' => $this->account->username->value,
            'email.value' => $this->account->email->value,
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

    assertDatabaseHas(Account::class, [
        'id' => $this->account->id,
        'name' => $this->account->name,
    ]);

    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Username,
        'value' => $this->account->username->value,
    ]);

    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Email,
        'value' => $this->account->email->value,
    ]);
});

test('updating account preserves password', function (): void {
    // Store original password hash for comparison
    $passwordHash = $this->account->password;

    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    // Verify password remains unchanged
    $this->account->refresh();

    expect($this->account->password)->toBe($passwordHash);
});

test('updated account maintains all expected model relationships', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->account->refresh();

    expect($this->account->name)->toBe($this->data->name)
        ->and($this->account->credentials)->toHaveCount(2)
        ->and($this->account->username)->not->toBeNull()
        ->and($this->account->email)->not->toBeNull()
        ->and($this->account->username->value)->toBe($this->data->username)
        ->and($this->account->email->value)->toBe($this->data->email)
        ->and($this->account->username->type)->toBe(AccountCredentialTypesEnum::Username)
        ->and($this->account->email->type)->toBe(AccountCredentialTypesEnum::Email)
        ->and($this->account->username->is_primary)->toBeTrue()
        ->and($this->account->email->is_primary)->toBeTrue();
});

test('partial updates work correctly', function (): void {
    // Keep existing credentials unchanged for partial update test
    $username = $this->account->username->value;
    $email = $this->account->email->value;

    // Update only name
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $username,
            'email.value' => $email,
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

    // Verify only name was updated
    assertDatabaseHas(Account::class, [
        'id' => $this->account->id,
        'name' => $this->data->name,
    ]);

    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Username,
        'value' => $username,
    ]);

    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->account->id,
        'type' => AccountCredentialTypesEnum::Email,
        'value' => $email,
    ]);
});

test('can delete account via delete action', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->callAction('delete')
        ->assertNotified()
        ->assertRedirect();

    // Verify account is deleted from database
    assertDatabaseMissing(Account::class, [
        'id' => $this->account->id,
    ]);

    // Verify account credentials are also deleted (cascade)
    assertDatabaseMissing(AccountCredential::class, [
        'account_id' => $this->account->id,
    ]);
});

test('can access view action from edit page', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->assertActionExists('view')
        ->assertActionEnabled('view')
        ->callAction('view');
});

test('delete action removes only the specified account', function (): void {
    livewire(EditAccount::class, ['record' => $this->accountA->id])
        ->callAction('delete')
        ->assertNotified();

    // Verify only the target account is deleted
    assertDatabaseMissing(Account::class, [
        'id' => $this->accountA->id,
    ]);

    // Verify other account remains untouched
    assertDatabaseHas(Account::class, [
        'id' => $this->accountB->id,
        'name' => $this->accountB->name,
    ]);

    // Verify other account's credentials remain
    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $this->accountB->id,
    ]);
});
