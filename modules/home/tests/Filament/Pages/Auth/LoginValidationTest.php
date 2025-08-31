<?php

use Venture\Home\Filament\Pages\Auth\Login;

use function Pest\Laravel\assertGuest;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    auth()->logout();
});

test('login form has correct components', function (): void {
    livewire(Login::class)
        ->assertFormExists()
        ->assertFormFieldExists('account_id')
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('remember');
});

test('user cannot login with invalid credentials', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => $this->account->username->value,
            'password' => 'wrong-password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors()
        ->assertNoRedirect();

    assertGuest();

    livewire(Login::class)
        ->fillForm([
            'account_id' => $this->account->email->value,
            'password' => 'wrong-password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors()
        ->assertNoRedirect();

    assertGuest();
});

test('user cannot login with non-existent credential', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => 'nonexistent',
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors()
        ->assertNoRedirect();

    assertGuest();
});

test('account_id field is required', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => '',
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['account_id' => 'required']);
});

test('password field is required', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => $this->account->username->value,
            'password' => '',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['password' => 'required']);
});
