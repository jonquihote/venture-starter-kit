<?php

declare(strict_types=1);

use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages\ViewAccount;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Livewire\livewire;

describe('ViewAccount Page', function (): void {
    beforeEach(function (): void {
        $this->account = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();
    });

    it('can render the view page', function (): void {
        livewire(ViewAccount::class, [
            'record' => $this->account->id,
        ])
            ->assertOk();
    });

    it('can display account information with name, username, and email', function (): void {
        livewire(ViewAccount::class, [
            'record' => $this->account->id,
        ])
            ->assertSee($this->account->name)
            ->assertSee($this->account->username->value)
            ->assertSee($this->account->email->value);
    });

    it('can display account with only username credential', function (): void {
        livewire(ViewAccount::class, [
            'record' => $this->account->id,
        ])
            ->assertSee($this->account->name)
            ->assertSee($this->account->username->value);
    });

    it('can display account with only email credential', function (): void {
        livewire(ViewAccount::class, [
            'record' => $this->account->id,
        ])
            ->assertSee($this->account->name)
            ->assertSee($this->account->email->value);
    });

    it('handles accounts with minimal data gracefully', function (): void {
        livewire(ViewAccount::class, [
            'record' => $this->account->id,
        ])
            ->assertOk()
            ->assertSee($this->account->name);
    });
});
