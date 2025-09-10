<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Hash;
use Venture\Alpha\Enums\AccountCredentialTypesEnum;
use Venture\Alpha\Filament\Clusters\Administration\Resources\Accounts\Pages\CreateAccount;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Livewire\livewire;

describe('CreateAccount Page', function (): void {
    beforeEach(function (): void {
        $account = Account::factory()->make();
        $username = AccountCredential::factory()->verified()->username()->make();
        $email = AccountCredential::factory()->verified()->email()->make();

        $this->formData = [
            'name' => $account->name,
            'password' => 'password1234',
            'password_confirmation' => 'password1234',
            'username' => [
                'value' => $username->value,
            ],
            'email' => [
                'value' => $email->value,
            ],
        ];
    });

    it('can render the create form page & ensure that the form schema exists', function (): void {
        livewire(CreateAccount::class)
            ->assertOk()
            ->assertSchemaExists('form');
    });

    it('can create a new account with valid data', function (): void {
        livewire(CreateAccount::class)
            ->fillForm($this->formData)
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified()
            ->assertRedirect();

        // Verify account is created
        $account = Account::where('name', $this->formData['name'])->first();
        expect($account)->not->toBeNull();

        // Verify password is hashed, not plain text
        expect($account->password)->not->toBe($this->formData['password']);
        expect(Hash::check($this->formData['password'], $account->password))->toBeTrue();

        // Verify credentials are created correctly with proper relationships
        $usernameCredential = AccountCredential::where('value', $this->formData['username']['value'])->first();
        expect($usernameCredential->type)->toBe(AccountCredentialTypesEnum::Username);
        expect($usernameCredential->is_primary)->toBeTrue();
        expect($usernameCredential->account_id)->toBe($account->id);

        $emailCredential = AccountCredential::where('value', $this->formData['email']['value'])->first();
        expect($emailCredential->type)->toBe(AccountCredentialTypesEnum::Email);
        expect($emailCredential->is_primary)->toBe(true);
        expect($emailCredential->account_id)->toBe($account->id);
    });

    describe('Name Validation', function (): void {
        it('requires name field', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'name' => '',
                ]))
                ->call('create')
                ->assertHasFormErrors(['name']);
        });

        it('rejects names with non-ASCII characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'name' => 'José María',
                ]))
                ->call('create')
                ->assertHasFormErrors(['name']);
        });

        it('rejects names with numbers or special characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'name' => 'John123',
                ]))
                ->call('create')
                ->assertHasFormErrors(['name']);
        });

        it('rejects names that are only spaces', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'name' => '   ',
                ]))
                ->call('create')
                ->assertHasFormErrors(['name']);
        });
    });

    describe('Password Validation', function (): void {
        it('requires password field', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'password' => '',
                    'password_confirmation' => '',
                ]))
                ->call('create')
                ->assertHasFormErrors(['password' => ['required']]);
        });

        it('requires password to be at least 12 characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'password' => 'short',
                    'password_confirmation' => 'short',
                ]))
                ->call('create')
                ->assertHasFormErrors(['password']);
        });

        it('requires password confirmation to match', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'password' => 'SecurePassword123',
                    'password_confirmation' => 'DifferentPassword123',
                ]))
                ->call('create')
                ->assertHasFormErrors(['password' => ['confirmed']]);
        });

    });

    describe('Username Validation', function (): void {
        it('requires username field', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => ''],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value' => ['required']]);
        });

        it('requires username to be at least 4 characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'ab'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to be maximum 16 characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'verylongusernamethatismorethan16chars'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to start with lowercase letter', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => '1testuser'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires username to end with letter or number', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'testuser_'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });

        it('rejects username with consecutive special characters', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => 'test..user'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });

        it('requires unique username', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'username' => ['value' => $this->currentAccount->username->value],
                ]))
                ->call('create')
                ->assertHasFormErrors(['username.value']);
        });
    });

    describe('Email Validation', function (): void {
        it('requires email field', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => ''],
                ]))
                ->call('create')
                ->assertHasFormErrors(['email.value' => ['required']]);
        });

        it('requires valid email format', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => 'invalid-email'],
                ]))
                ->call('create')
                ->assertHasFormErrors(['email.value']);
        });

        it('requires unique email', function (): void {
            livewire(CreateAccount::class)
                ->fillForm(array_merge($this->formData, [
                    'email' => ['value' => $this->currentAccount->email->value],
                ]))
                ->call('create')
                ->assertHasFormErrors(['email.value']);
        });
    });
});
