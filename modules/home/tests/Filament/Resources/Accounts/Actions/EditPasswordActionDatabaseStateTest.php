<?php

use Illuminate\Support\Facades\Hash;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ViewAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Create target account to edit password on
    $this->targetAccount = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();
});

test('database record updates correctly', function (): void {
    $newPassword = 'password123';

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])
        ->assertHasNoFormErrors();

    // Verify database was updated
    assertDatabaseHas(Account::class, [
        'id' => $this->targetAccount->id,
        'name' => $this->targetAccount->name, // Other fields preserved
    ]);

    // Verify password change (can't directly check hashed value in DB)
    $this->targetAccount->refresh();
    expect(Hash::check($newPassword, $this->targetAccount->password))->toBeTrue();
});

test('maintains account data integrity during update', function (): void {
    $originalName = $this->targetAccount->name;
    $originalCreatedAt = $this->targetAccount->created_at;

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();

    // Verify other fields remain unchanged
    expect($this->targetAccount->name)->toBe($originalName)
        ->and($this->targetAccount->created_at->eq($originalCreatedAt))->toBeTrue()
        ->and($this->targetAccount->credentials)->toHaveCount(2);
});

test('preserves other account fields unchanged', function (): void {
    // Store original values
    $originalName = $this->targetAccount->name;
    $originalCreatedAt = $this->targetAccount->created_at;

    // Wait a moment to ensure timestamp difference
    usleep(100000); // 100ms

    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->callAction('edit-password', [
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertHasNoFormErrors();

    $this->targetAccount->refresh();

    // Only password should change, updated_at will change, but others should remain
    expect($this->targetAccount->name)->toBe($originalName)
        ->and($this->targetAccount->created_at->eq($originalCreatedAt))->toBeTrue()
        // updated_at should be different from created_at (though it might be the same due to fast execution)
        ->and($this->targetAccount->updated_at->gte($originalCreatedAt))->toBeTrue() // Should be >= created_at
        // Verify username and email credentials remain intact
        ->and($this->targetAccount->username)->not->toBeNull()
        ->and($this->targetAccount->email)->not->toBeNull()
        // Verify password was actually changed
        ->and(Hash::check('password123', $this->targetAccount->password))->toBeTrue();
});
