<?php

namespace Venture\Home\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getAccountIDFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getAccountIDFormComponent(): Component
    {
        return TextInput::make('account_id')
            ->label(__('home::filament/pages/login/form.fields.account_id.label'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes([
                'tabindex' => 1,
                'data-test' => 'login_input_account_id',
            ]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('home::filament/pages/login/form.fields.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'home::filament/pages/login/form.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes([
                'tabindex' => 2,
                'data-test' => 'login_input_password',
            ]);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('home::filament/pages/login/form.fields.remember.label'))
            ->extraInputAttributes([
                'data-test' => 'login_input_remember',
            ]);
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('home::filament/pages/login/form.actions.continue.label'))
            ->submit('authenticate')
            ->extraAttributes([
                'data-test' => 'login_button_continue',
            ]);
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'password' => $data['password'],

            function (Builder $builder) use ($data): void {
                $builder->whereHas('credentials', function (Builder $builder) use ($data): void {
                    $builder->where('value', $data['account_id']);
                });
            },
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.account_id' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
