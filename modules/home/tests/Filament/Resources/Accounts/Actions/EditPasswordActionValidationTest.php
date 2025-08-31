<?php

use Venture\Home\Filament\Resources\Accounts\Pages\ViewAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Create target account to edit password on
    $this->targetAccount = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();
});

test('validates password minimum length requirement', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertHasFormErrors(['password']);
});

test('requires password confirmation matching', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ])
        ->assertHasFormErrors(['password']);
});

test('rejects empty password', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertHasFormErrors(['password']);
});

test('requires password confirmation field', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            // Missing password_confirmation
        ])
        ->assertHasFormErrors(['password_confirmation']);
});

test('shows validation errors for mismatched passwords', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ])
        ->assertHasFormErrors(['password']);
});
