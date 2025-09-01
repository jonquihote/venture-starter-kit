<?php

use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\CreateAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Existing account for uniqueness validation testing
    $this->account = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Fresh test data for form submissions
    $this->data = Account::factory()->credentials()->make();
});

test('name is required', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

test('password is required', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => '',
            'password_confirmation' => '',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['password' => 'required']);
});

test('password confirmation is required', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => '',
            'password_confirmation' => '',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['password_confirmation' => 'required']);
});

test('password confirmation must match password', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => '',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['password']);
});

test('username value is required', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => 'password',
            'username.value' => '',
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['username.value' => 'required']);
});

test('email value is required', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => '',
            'username.value' => $this->data->username,
            'email.value' => '',
        ])
        ->call('create')
        ->assertHasFormErrors(['email.value' => 'required']);
});

test('email value must be valid email format', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => '',
            'username.value' => $this->data->username,
            'email.value' => 'invalid-email-format',
        ])
        ->call('create')
        ->assertHasFormErrors(['email.value']);
});

test('username value must be unique', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => 'password',
            'username.value' => $this->account->username->value,
            'email.value' => $this->data->email,
        ])
        ->call('create')
        ->assertHasFormErrors(['username.value']);
});

test('email value must be unique', function (): void {
    livewire(CreateAccount::class)
        ->fillForm([
            'name' => $this->data->name,
            'password' => 'password',
            'password_confirmation' => 'password',
            'username.value' => $this->data->username,
            'email.value' => $this->account->email->value,
        ])
        ->call('create')
        ->assertHasFormErrors(['email.value']);
});

test('form validation with datasets', function (string $field, mixed $value, string $expectedError): void {
    $baseData = [
        'name' => $this->data->name,
        'password' => 'password',
        'password_confirmation' => 'password',
        'username.value' => $this->data->username,
        'email.value' => $this->data->email,
    ];

    $baseData[$field] = $value;

    livewire(CreateAccount::class)
        ->fillForm($baseData)
        ->call('create')
        ->assertHasFormErrors([$field => $expectedError]);
})->with([
    'name required' => ['name', '', 'required'],
    'password required' => ['password', '', 'required'],
    'password confirmation required' => ['password_confirmation', '', 'required'],
    'username.value required' => ['username.value', '', 'required'],
    'email.value required' => ['email.value', '', 'required'],
    'email.value invalid format' => ['email.value', 'not-an-email', 'email'],
]);
