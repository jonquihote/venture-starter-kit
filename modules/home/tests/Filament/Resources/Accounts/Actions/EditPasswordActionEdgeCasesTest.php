<?php

use Illuminate\Support\Facades\Hash;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ViewAccount;
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

test('handles very long passwords', function (): void {
    $longPassword = str_repeat('a', 1000) . '123'; // 1003 characters

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $longPassword,
            'password_confirmation' => $longPassword,
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $this->targetAccount->refresh();
    expect(Hash::check($longPassword, $this->targetAccount->password))->toBeTrue();
});

test('supports special characters in passwords', function (): void {
    $specialPassword = '!@#$%^&*()_+-=[]{}|;:,.<>?`~';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $specialPassword,
            'password_confirmation' => $specialPassword,
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $this->targetAccount->refresh();
    expect(Hash::check($specialPassword, $this->targetAccount->password))->toBeTrue();
});

test('processes unicode characters correctly', function (): void {
    $unicodePassword = 'pássw🔑rd123ñüé';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $unicodePassword,
            'password_confirmation' => $unicodePassword,
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $this->targetAccount->refresh();
    expect(Hash::check($unicodePassword, $this->targetAccount->password))->toBeTrue();
});

test('allows consecutive password updates', function (): void {
    // First password update
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors();

    // Second password update immediately after
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $this->targetAccount->refresh();
    expect(Hash::check('newpassword123', $this->targetAccount->password))->toBeTrue()
        ->and(Hash::check('password123', $this->targetAccount->password))->toBeFalse();
});

test('handles accounts with different password gracefully', function (): void {
    // Create account with custom password
    $customAccount = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create(['password' => 'oldpassword123']);

    livewire(ViewAccount::class, ['record' => $customAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $customAccount->refresh();
    expect(Hash::check('password123', $customAccount->password))->toBeTrue()
        ->and(Hash::check('oldpassword123', $customAccount->password))->toBeFalse();
});
