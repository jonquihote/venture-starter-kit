<?php

declare(strict_types=1);

use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages\EditAccount;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

describe('EditAccount Page', function (): void {
    beforeEach(function (): void {
        $this->formAccount = Account::factory()
            ->has(AccountCredential::factory()->verified()->username(), 'credentials')
            ->has(AccountCredential::factory()->verified()->email(), 'credentials')
            ->create();

        $account = Account::factory()->make();
        $username = AccountCredential::factory()->username()->make();
        $email = AccountCredential::factory()->email()->make();

        $this->formData = [
            'name' => $account->name,
            'username' => [
                'value' => $username->value,
            ],
            'email' => [
                'value' => $email->value,
            ],
        ];
    });

    it('can render the edit form with existing account data', function (): void {
        livewire(EditAccount::class, [
            'record' => $this->formAccount->id,
        ])
            ->assertOk()
            ->assertSchemaExists('form')
            ->assertSchemaStateSet([
                'name' => $this->formAccount->name,
                'username.value' => $this->formAccount->username->value,
                'email.value' => $this->formAccount->email->value,
            ]);
    });

    it('can update an account with valid data', function (): void {
        livewire(EditAccount::class, [
            'record' => $this->formAccount->id,
        ])
            ->fillForm($this->formData)
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        // Verify account is updated using assertDatabaseHas
        assertDatabaseHas(Account::class, [
            'id' => $this->formAccount->id,
            'name' => $this->formData['name'],
        ]);

        // Verify credentials are updated
        assertDatabaseHas(AccountCredential::class, [
            'account_id' => $this->formAccount->id,
            'type' => AccountCredentialTypesEnum::Username,
            'value' => $this->formData['username']['value'],
            'is_primary' => true,
        ]);

        assertDatabaseHas(AccountCredential::class, [
            'account_id' => $this->formAccount->id,
            'type' => AccountCredentialTypesEnum::Email,
            'value' => $this->formData['email']['value'],
            'is_primary' => true,
        ]);
    });

    describe('Name Validation', function (): void {
        it('requires name field', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'name' => '',
                ]))
                ->call('save')
                ->assertHasFormErrors(['name' => ['required']]);
        });

        it('rejects names with non-ASCII characters', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'name' => 'José María',
                ]))
                ->call('save')
                ->assertHasFormErrors(['name']);
        });

        it('rejects names with numbers or special characters', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'name' => 'John123',
                ]))
                ->call('save')
                ->assertHasFormErrors(['name']);
        });

        it('rejects names that are only spaces', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'name' => '   ',
                ]))
                ->call('save')
                ->assertHasFormErrors(['name']);
        });
    });

    describe('Username Validation', function (): void {
        it('requires username field', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => ''],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value' => ['required']]);
        });

        it('allows updating to the same username (ignores own value in unique validation)', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => $this->formAccount->username->value], // Same username
                ]))
                ->call('save')
                ->assertHasNoFormErrors(['username.value']);
        });

        it('rejects duplicate username from another account', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => $this->currentAccount->username->value], // Try to use existing username
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to be at least 4 characters', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'ab'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to be maximum 16 characters', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'verylongusernamethatismorethan16chars'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to start with lowercase letter', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => '1testuser'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to end with letter or number', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'testuser_'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });

        it('rejects username with consecutive special characters', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'test..user'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['username.value']);
        });
    });

    describe('Email Validation', function (): void {
        it('requires email field', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => ''],
                ]))
                ->call('save')
                ->assertHasFormErrors(['email.value' => ['required']]);
        });

        it('requires valid email format', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => 'invalid-email'],
                ]))
                ->call('save')
                ->assertHasFormErrors(['email.value']);
        });

        it('allows updating to the same email (ignores own value in unique validation)', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => $this->formAccount->email->value], // Same email
                ]))
                ->call('save')
                ->assertHasNoFormErrors(['email.value']);
        });

        it('rejects duplicate email from another account', function (): void {
            livewire(EditAccount::class, [
                'record' => $this->formAccount->id,
            ])
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => $this->currentAccount->email->value], // Try to use existing email
                ]))
                ->call('save')
                ->assertHasFormErrors(['email.value']);
        });
    });
});
