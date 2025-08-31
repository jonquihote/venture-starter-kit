<?php

use Venture\Home\Filament\Pages\Auth\Login;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    auth()->logout();
});

test('login page can be rendered', function (): void {
    livewire(Login::class)
        ->assertOk();
});

test('user can login with username credential', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => $this->account->username->value,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    assertAuthenticatedAs($this->account);
});

test('user can login with email credential', function (): void {
    livewire(Login::class)
        ->fillForm([
            'account_id' => $this->account->email->value,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    assertAuthenticatedAs($this->account);
});
