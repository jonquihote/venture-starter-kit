<?php

use Venture\Home\Filament\Resources\Accounts\Pages\EditAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Primary account for testing validation rules
    $this->account = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Additional accounts for uniqueness constraint testing
    $this->accountA = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    $this->accountB = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Test data for form submissions
    $this->data = Account::factory()->credentials()->make();
});

test('name is required on update', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => '',
            'username.value' => $this->data->username,
            'email.value' => $this->data->email,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

test('username value is required on update', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => '',
            'email.value' => $this->data->email,
        ])
        ->call('save')
        ->assertHasFormErrors(['username.value' => 'required']);
});

test('email value is required on update', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->data->username,
            'email.value' => '',
        ])
        ->call('save')
        ->assertHasFormErrors(['email.value' => 'required']);
});

test('email value must be valid email format on update', function (): void {
    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->data->username,
            'email.value' => 'invalid-email-format',
        ])
        ->call('save')
        ->assertHasFormErrors(['email.value']);
});

test('username value must be unique (cannot use another accounts username)', function (): void {
    livewire(EditAccount::class, ['record' => $this->accountA->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->accountB->username->value, // Try to use taken username
            'email.value' => $this->accountA->email->value,
        ])
        ->call('save')
        ->assertHasFormErrors(['username.value']);
});

test('email value must be unique (cannot use another accounts email)', function (): void {
    livewire(EditAccount::class, ['record' => $this->accountA->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->accountA->username->value,
            'email.value' => $this->accountB->email->value, // Try to use taken email
        ])
        ->call('save')
        ->assertHasFormErrors(['email.value']);
});

test('form validation with datasets on update', function (string $field, mixed $value, string $expectedError): void {
    $baseData = [
        'name' => $this->data->name,
        'username.value' => $this->data->username,
        'email.value' => $this->data->email,
    ];

    $baseData[$field] = $value;

    livewire(EditAccount::class, ['record' => $this->account->id])
        ->fillForm($baseData)
        ->call('save')
        ->assertHasFormErrors([$field => $expectedError]);
})->with([
    'name required' => ['name', '', 'required'],
    'username.value required' => ['username.value', '', 'required'],
    'email.value required' => ['email.value', '', 'required'],
    'email.value invalid format' => ['email.value', 'invalid-email-format', 'email'],
]);

test('multiple unique constraint violations show appropriate errors', function (): void {
    livewire(EditAccount::class, ['record' => $this->accountA->id])
        ->fillForm([
            'name' => $this->data->name,
            'username.value' => $this->accountB->username->value, // Taken username
            'email.value' => $this->accountB->email->value, // Taken email
        ])
        ->call('save')
        ->assertHasFormErrors(['username.value', 'email.value']);
});
