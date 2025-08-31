@php
    use Illuminate\Database\Eloquent\Builder;
    use Venture\Home\Enums\AccountCredentialTypesEnum;
    use Venture\Home\Models\Account;

    $account = Account::query()
        ->whereEmail('zeus@example.com')
        ->whereUsername('zeus')
        ->first();

    $team = $account->ownedTeams->first();
@endphp

@env('local')
    <div @class([
        'login-links',
    ])>
        <span>
            {{ __('home::filament/render-hooks/panels/auth-login-form-after/login-links.instructions.login-as') }}
        </span>
        <x-login-link
            key="{{ $account->getKey() }}"
            redirect-url="{{ route('filament.home.pages.dashboard', [$team]) }}"
            label="{{ __('home::filament/render-hooks/panels/auth-login-form-after/login-links.labels.super-administrator') }}"
        />
    </div>
@endenv
