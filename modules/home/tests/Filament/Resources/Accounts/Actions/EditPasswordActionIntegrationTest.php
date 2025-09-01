<?php

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
});

test('ViewAccount page action integration works correctly', function (): void {
    livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->assertActionExists('edit-password')
        ->assertActionVisible('edit-password')
        ->assertActionEnabled('edit-password')
        ->mountAction('edit-password')
        ->assertFormExists();
});

test('AccountsTable action integration works correctly', function (): void {
    livewire(ListAccounts::class)
        ->assertTableActionExists('edit-password')
        ->assertTableActionVisible('edit-password', $this->targetAccount)
        ->assertTableActionEnabled('edit-password', $this->targetAccount);
});

test('modal configuration is correct', function (): void {
    $component = livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->mountAction('edit-password');

    $action = $component->instance()->getMountedAction();

    // Verify modal configuration
    expect($action->getModalWidth()->value)->toBe('sm') // Width::Small enum value
        ->and($action->getColor())->toBe('primary')
        ->and($action->getLabel())->not->toBeEmpty()
        ->and($action->getModalHeading())->not->toBeEmpty();
});

test('form schema loading works correctly', function (): void {
    $component = livewire(ViewAccount::class, ['record' => $this->targetAccount->id])
        ->mountAction('edit-password');

    // Verify form has expected fields
    $component->assertFormFieldExists('password')
        ->assertFormFieldExists('password_confirmation');
});
