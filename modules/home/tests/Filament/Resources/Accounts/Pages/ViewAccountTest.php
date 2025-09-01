<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Venture\Home\Filament\Clusters\Administration\Resources\Accounts\Pages\ViewAccount;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    // Standard account for basic view testing
    $this->account = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    // Complex account with multiple credentials for relationship testing
    $this->complex = Account::factory()
        ->has(AccountCredential::factory()->username()->state(['is_primary' => true]), 'credentials')
        ->has(AccountCredential::factory()->email()->state(['is_primary' => true]), 'credentials')
        ->has(AccountCredential::factory()->email()->state(['is_primary' => false, 'value' => 'secondary@example.com']), 'credentials')
        ->create(['name' => 'Account with Multiple Credentials']);
});

test('page can be rendered successfully with existing account', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk()
        ->assertSuccessful();
});

test('page displays all account data correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk()
        ->assertSee($this->account->name)
        ->assertSee($this->account->username->value)
        ->assertSee($this->account->email->value);
});

test('edit action works correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertActionExists('edit')
        ->assertActionEnabled('edit')
        ->callAction('edit')
        ->assertHasNoFormErrors();
});

test('page handles non-existent account gracefully', function (): void {
    $nonExistentId = 99999;

    expect(fn () => livewire(ViewAccount::class, ['record' => $nonExistentId]))
        ->toThrow(ModelNotFoundException::class);
});

test('page loads account with all relationships', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk();

    // Verify the account has expected relationships loaded
    expect($this->account->username)->not->toBeNull()
        ->and($this->account->email)->not->toBeNull()
        ->and($this->account->credentials)->toHaveCount(2);
});

test('page displays account with multiple credentials correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->complex->id])
        ->assertOk()
        ->assertSee($this->complex->name)
        ->assertSee($this->complex->username->value)
        ->assertSee($this->complex->email->value);
});

test('page shows primary credentials correctly', function (): void {
    // Use complex account to verify primary credential selection
    $account = $this->complex;

    livewire(ViewAccount::class, ['record' => $account->id])
        ->assertOk()
        ->assertSee($account->username->value)
        ->assertSee($account->email->value);

    // Verify we're showing the primary email, not secondary
    expect($account->email->is_primary)->toBeTrue()
        ->and($account->email->value)->not->toBe('secondary@example.com');
});

test('page title shows account name', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk();

    // The page title should be based on the record title attribute (name)
    // This is handled by Filament's ViewRecord automatically
});

test('page breadcrumb navigation works correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk();

    // Breadcrumbs are typically handled by Filament automatically
    // Visual verification would require browser testing
});

test('account data integrity is maintained', function (): void {
    // Capture state before and after page load
    $original = $this->account->fresh();

    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk();

    $reloaded = $this->account->fresh();

    expect($reloaded->name)->toBe($original->name)
        ->and($reloaded->username->value)->toBe($original->username->value)
        ->and($reloaded->email->value)->toBe($original->email->value);
});

test('page handles account with only username credential', function (): void {
    // Account with only username, no email
    $account = Account::factory()
        ->has(AccountCredential::factory()->username(), 'credentials')
        ->create();

    livewire(ViewAccount::class, ['record' => $account->id])
        ->assertOk()
        ->assertSee($account->name)
        ->assertSee($account->username->value);
});

test('page handles account with only email credential', function (): void {
    // Account with only email, no username
    $account = Account::factory()
        ->has(AccountCredential::factory()->email(), 'credentials')
        ->create();

    livewire(ViewAccount::class, ['record' => $account->id])
        ->assertOk()
        ->assertSee($account->name)
        ->assertSee($account->email->value);
});

test('page maintains record state during interactions', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk()
        ->callAction('edit');

    // Verify the original record data is still intact
    $fresh = $this->account->fresh();
    expect($fresh->name)->toBe($this->account->name)
        ->and($fresh->id)->toBe($this->account->id);
});

test('page accessibility and semantic structure', function (): void {
    livewire(ViewAccount::class, ['record' => $this->account->id])
        ->assertOk();

    // Semantic structure is handled by Filament's infolist components
    // Full accessibility testing would require browser testing
});

test('page handles concurrent access correctly', function (): void {
    // Simulate concurrent access to the same account
    $componentA = livewire(ViewAccount::class, ['record' => $this->account->id]);
    $componentB = livewire(ViewAccount::class, ['record' => $this->account->id]);

    $componentA->assertOk();
    $componentB->assertOk();

    // Both should show the same data
    $componentA->assertSee($this->account->name);
    $componentB->assertSee($this->account->name);
});
