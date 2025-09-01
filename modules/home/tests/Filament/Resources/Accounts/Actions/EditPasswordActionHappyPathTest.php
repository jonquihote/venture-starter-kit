<?php

use Illuminate\Support\Facades\Hash;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ListAccounts;
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

    // Store original password hash for comparison
    $this->originalPasswordHash = $this->targetAccount->password;
});

test('can update password from ViewAccount page with valid data', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->assertActionExists('edit-password')
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    // Verify password was updated in database
    $this->targetAccount->refresh();
    expect(Hash::check('password123', $this->targetAccount->password))->toBeTrue();
});

test('can update password from ListAccounts table with valid data', function (): void {
    livewire(ListAccounts::class)
        ->assertTableActionExists('edit-password')
        ->callTableAction('edit-password', $this->targetAccount, [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();

    // Verify password was updated in database
    $this->targetAccount->refresh();
    expect(Hash::check('password123', $this->targetAccount->password))->toBeTrue();
});

test('password is properly hashed when updated', function (): void {
    $plainPassword = 'password123';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $plainPassword,
            'password_confirmation' => $plainPassword,
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();

    // Verify password is hashed (not stored as plain text)
    expect($this->targetAccount->password)->not->toBe($plainPassword)
        ->and(Hash::check($plainPassword, $this->targetAccount->password))->toBeTrue()
        ->and($this->targetAccount->password)->not->toBe($this->originalPasswordHash);
});

test('success notification is displayed after password update', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors()
        ->assertNotified();
});

test('modal behavior works correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->assertActionExists('edit-password')
        ->assertActionVisible('edit-password')
        ->assertActionEnabled('edit-password')
        ->mountAction('edit-password')
        ->assertFormExists();
});
