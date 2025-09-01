<?php

use Illuminate\Support\Facades\Hash;
use Venture\Home\Enums\AccountCredentialTypesEnum;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\CreateAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Test account data for form submissions
    $this->data = Account::factory()->credentials()->make();
});

test('page can be rendered successfully', function (): void {
    livewire(CreateAccount::class)
        ->assertOk();
});

test('form contains all required fields', function (): void {
    livewire(CreateAccount::class)
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('password_confirmation')
        ->assertFormFieldExists('username.value')
        ->assertFormFieldExists('email.value');
});

test('password fields are visible on create page', function (): void {
    livewire(CreateAccount::class)
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('password_confirmation')
        ->assertFormFieldIsEnabled('password')
        ->assertFormFieldIsEnabled('password_confirmation');
});

test('can create account with valid data', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => 'password',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified()
        ->assertRedirect();

    // Verify account was created in database
    assertDatabaseHas(Account::class, [
        'name' => $this->data->name,
    ]);

    // Verify account count increased by 1 (admin + new account)
    assertDatabaseCount('home_accounts', 2);

    // Get the created account and verify relationships
    $account = Account::where('name', $this->data->name)->first();

    expect($account)->not->toBeNull()
        ->and(Hash::check('password', $account->password))->toBeTrue();

    // Verify username credential was created
    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $account->id,
        'type' => AccountCredentialTypesEnum::Username,
        'value' => $this->data->username,
        'is_primary' => true,
    ]);

    // Verify email credential was created
    assertDatabaseHas(AccountCredential::class, [
        'account_id' => $account->id,
        'type' => AccountCredentialTypesEnum::Email,
        'value' => $this->data->email,
        'is_primary' => true,
    ]);

    assertDatabaseCount('home_account_credentials', 4);
});
