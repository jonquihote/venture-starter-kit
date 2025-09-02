@php
    use Illuminate\Database\Eloquent\Builder;
    use Venture\Alpha\Enums\AccountCredentialTypesEnum;
    use Venture\Alpha\Models\Account;

    $zeus = Account::query()
        ->whereEmail('zeus@example.com')
        ->whereUsername('zeus')
        ->first();

    $luffy = Account::query()
        ->whereEmail('luffy@example.com')
        ->whereUsername('luffy')
        ->first();

    $tanjiro = Account::query()
        ->whereEmail('tanjiro@example.com')
        ->whereUsername('tanjiro')
        ->first();

    $jinWoo = Account::query()
        ->whereEmail('jin.woo@example.com')
        ->whereUsername('jin.woo')
        ->first();
@endphp

@env('local')
    <div
        @class([
            'flex flex-col',
            'space-y-2',
        ])
    >
        <div @class([
            'login-links',
        ])>
            <span>
                {{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.instructions.login-as') }}
            </span>
            <x-login-link
                key="{{ $zeus->getKey() }}"
                redirect-url="{{ route('filament.home.pages.dashboard', [$zeus->ownedTeams->first()]) }}"
                label="{{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.labels.super-administrator') }}"
            />
        </div>

        <div @class([
            'login-links',
        ])>
            <span>
                {{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.instructions.login-as') }}
            </span>
            <x-login-link
                key="{{ $luffy->getKey() }}"
                redirect-url="{{ route('filament.home.pages.dashboard', [$luffy->ownedTeams->first()]) }}"
                label="{{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.labels.administrator') }} 1"
            />
        </div>

        <div @class([
            'login-links',
        ])>
            <span>
                {{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.instructions.login-as') }}
            </span>
            <x-login-link
                key="{{ $tanjiro->getKey() }}"
                redirect-url="{{ route('filament.home.pages.dashboard', [$tanjiro->ownedTeams->first()]) }}"
                label="{{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.labels.administrator') }} 2"
            />
        </div>

        <div @class([
            'login-links',
        ])>
            <span>
                {{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.instructions.login-as') }}
            </span>
            <x-login-link
                key="{{ $jinWoo->getKey() }}"
                redirect-url="{{ route('filament.home.pages.dashboard', [$jinWoo->ownedTeams->first()]) }}"
                label="{{ __('alpha::filament/render-hooks/panels/auth-login-form-after/login-links.labels.administrator') }} 3"
            />
        </div>
    </div>
@endenv
