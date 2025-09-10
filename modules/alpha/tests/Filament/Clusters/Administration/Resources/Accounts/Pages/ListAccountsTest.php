<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages\ListAccounts;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Livewire\livewire;

describe('ListAccounts Page', function (): void {
    it('can load the page', function (): void {
        livewire(ListAccounts::class)
            ->assertOk();
    });

    it('can list all accounts with name, username, and email columns', function (): void {
        $accounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(3)
            ->create();

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords($accounts);
    });

    it('displays correct table columns', function (): void {
        $account = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords([$account])
            ->assertTableColumnExists('name')
            ->assertTableColumnExists('username.value')
            ->assertTableColumnExists('email.value');
    });

    it('can search accounts by name', function (): void {
        $targetAccount = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        $otherAccounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(2)
            ->create();

        $accounts = $otherAccounts->concat([$targetAccount]);

        [$visibleAccounts, $hiddenAccounts] = $accounts->partition(function (Account $account) use ($targetAccount) {
            return $account->name === $targetAccount->name;
        });

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords($accounts)
            ->searchTable($targetAccount->name)
            ->assertCanSeeTableRecords($visibleAccounts)
            ->assertCanNotSeeTableRecords($hiddenAccounts);
    });

    it('can search accounts by username', function (): void {
        $targetAccount = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        $otherAccounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(2)
            ->create();

        $accounts = $otherAccounts->concat([$targetAccount]);

        [$visibleAccounts, $hiddenAccounts] = $accounts->partition(function (Account $account) use ($targetAccount) {
            return $account->username->is($targetAccount->username);
        });

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords($accounts)
            ->searchTable($targetAccount->username->value)
            ->assertCanSeeTableRecords($visibleAccounts)
            ->assertCanNotSeeTableRecords($hiddenAccounts);
    });

    it('can search accounts by email', function (): void {
        $targetAccount = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        $otherAccounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(2)
            ->create();

        $accounts = $otherAccounts->concat([$targetAccount]);

        [$visibleAccounts, $hiddenAccounts] = $accounts->partition(function (Account $account) use ($targetAccount) {
            return $account->email->is($targetAccount->email);
        });

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords($accounts)
            ->searchTable($targetAccount->email->value)
            ->assertCanSeeTableRecords($visibleAccounts)
            ->assertCanNotSeeTableRecords($hiddenAccounts);
    });

    it('can search with partial terms', function (): void {
        $targetAccount = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        $otherAccounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(2)
            ->create();

        $accounts = $otherAccounts->concat([$targetAccount]);

        $firstName = Str::before($targetAccount->name, ' ');

        [$visibleAccounts, $hiddenAccounts] = $accounts->partition(function (Account $account) use ($firstName) {
            return Str::contains($account->name, $firstName);
        });

        livewire(ListAccounts::class)
            ->assertCanSeeTableRecords($accounts)
            ->searchTable($firstName) // Partial search using first word
            ->assertCanSeeTableRecords($visibleAccounts)
            ->assertCanNotSeeTableRecords($hiddenAccounts);
    });

    it('can clear search and show all records', function (): void {
        $accounts = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->count(3)
            ->create();

        livewire(ListAccounts::class)
            ->searchTable($accounts->first()->name)
            ->assertCanSeeTableRecords([$accounts->first()])
            ->searchTable('') // Clear search
            ->assertCanSeeTableRecords($accounts);
    });
});
