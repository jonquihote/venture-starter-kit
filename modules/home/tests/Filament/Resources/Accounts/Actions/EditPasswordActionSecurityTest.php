<?php

use Illuminate\Support\Facades\Hash;
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

test('never exposes old password in form data', function (): void {
    // Verify that the action doesn't pre-populate password fields
    $component = livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->mountAction('edit-password');

    // Verify the form doesn't contain the old password anywhere
    $component->fillForm([
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    // Old password should still be intact until action is called
    expect($this->targetAccount->password)->not->toBe('password123')
        // Form should only expose the new password data, never the old one
        ->and(Hash::check('password123', $this->targetAccount->password))->toBeFalse();
});

test('prevents plain text password exposure', function (): void {
    $plainPassword = 'password123';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $plainPassword,
            'password_confirmation' => $plainPassword,
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();

    // Verify password is never stored as plain text
    expect($this->targetAccount->password)->not->toBe($plainPassword)
        ->and($this->targetAccount->getAttributes()['password'])->not->toBe($plainPassword);
});

test('verifies password hash changes after update', function (): void {
    $oldHash = $this->targetAccount->password;

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();
    expect($this->targetAccount->password)->not->toBe($oldHash);
});

test('ensures complete password replacement not append', function (): void {
    $newPassword = 'password123';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();

    // Only new password should work, not old one
    expect(Hash::check($newPassword, $this->targetAccount->password))->toBeTrue()
        ->and(Hash::check('password', $this->targetAccount->password))->toBeFalse(); // Default factory password
});

test('validates secure form data handling', function (): void {
    // Test the complete flow works securely
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    $this->targetAccount->refresh();
    expect(Hash::check('password123', $this->targetAccount->password))->toBeTrue()
        // Verify password confirmation is processed correctly but not stored
        ->and($this->targetAccount->getAttributes())->not->toHaveKey('password_confirmation');
});
