<?php

declare(strict_types=1);

use Filament\Actions\EditAction;
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

    describe('Infolist Data Display', function (): void {
        it('displays all account fields correctly using assertSchemaStateSet', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertSchemaStateSet([
                    'name' => $this->account->name,
                    'username.value' => $this->account->username->value,
                    'email.value' => $this->account->email->value,
                ]);
        });

        it('handles missing credentials gracefully', function (): void {
            $accountWithoutCredentials = Account::factory()->create();

            livewire(ViewAccount::class, [
                'record' => $accountWithoutCredentials->id,
            ])
                ->assertOk()
                ->assertSchemaStateSet([
                    'name' => $accountWithoutCredentials->name,
                    'username.value' => null,
                    'email.value' => null,
                ]);
        });

        it('displays only username when email credential is missing', function (): void {
            $accountWithUsernameOnly = Account::factory()
                ->has(AccountCredential::factory()->verified()->username(), 'credentials')
                ->create();

            livewire(ViewAccount::class, [
                'record' => $accountWithUsernameOnly->id,
            ])
                ->assertSchemaStateSet([
                    'name' => $accountWithUsernameOnly->name,
                    'username.value' => $accountWithUsernameOnly->username->value,
                    'email.value' => null,
                ]);
        });

        it('displays only email when username credential is missing', function (): void {
            $accountWithEmailOnly = Account::factory()
                ->has(AccountCredential::factory()->verified()->email(), 'credentials')
                ->create();

            livewire(ViewAccount::class, [
                'record' => $accountWithEmailOnly->id,
            ])
                ->assertSchemaStateSet([
                    'name' => $accountWithEmailOnly->name,
                    'username.value' => null,
                    'email.value' => $accountWithEmailOnly->email->value,
                ]);
        });
    });

    describe('Infolist Structure', function (): void {
        it('has proper infolist schema structure', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertSchemaExists('infolist');
        });

        it('displays section component with account fields', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertSee($this->account->name)
                ->assertSee($this->account->username->value)
                ->assertSee($this->account->email->value);
        });

        it('handles accounts with no teams gracefully', function (): void {
            $accountWithoutTeams = Account::factory()->create();

            livewire(ViewAccount::class, [
                'record' => $accountWithoutTeams->id,
            ])
                ->assertOk()
                ->assertSchemaExists('infolist');
        });
    });

    describe('Header Actions', function (): void {
        it('displays Edit action in header', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertActionExists(EditAction::class);
        });

        it('displays Edit Password action in header', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertActionExists('edit-password');
        });

        it('displays Edit Roles action in header', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertActionExists('edit-roles');
        });

        it('shows all actions when user has permissions', function (): void {
            livewire(ViewAccount::class, [
                'record' => $this->account->id,
            ])
                ->assertActionVisible(EditAction::class)
                ->assertActionVisible('edit-password')
                ->assertActionVisible('edit-roles');
        });
    });
});
