<?php

namespace Venture\Home\Actions;

use Filament\Actions\Action as FilamentAction;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\Support\Assets\Js;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Lorisleiva\Actions\Action;
use Venture\Home\Http\Middleware\EnsureSingleTeamMode;
use Venture\Home\Http\Middleware\EnsureTeamAccess;
use Venture\Home\Http\Middleware\EnsureTeamHasSubscription;
use Venture\Home\Http\Middleware\UpdateCurrentTeam;
use Venture\Home\Models\Team;
use Venture\Home\Settings\TenancySettings;

class MakePanel extends Action
{
    public function handle(Panel $panel, string $name, string $slug): Panel
    {
        return $panel
            ->id($slug)
            ->path($slug)
            ->spa(hasPrefetching: true)
            ->viteTheme('resources/css/app.css')
            ->assets([
                Js::make('livewire-echo', Vite::asset('resources/js/livewire-echo.ts'))->module(),
            ])
            ->homeUrl(function () {
                return route('filament.home.pages.dashboard', [Filament::getTenant()]);
            })
            ->userMenuItems([
                'logout' => function (FilamentAction $action) {
                    return $action->label('Log out');
                },
            ])
            ->tenantMenu(function (TenancySettings $settings, Panel $panel) {
                if ($settings->is_single_team_mode) {
                    return false;
                }

                return Auth::user()->getTenants($panel)->count() > 1;
            })
            ->topNavigation()
            ->databaseNotifications()
            ->strictAuthorization()
            ->tenant(Team::class, slugAttribute: 'slug')
            ->discoverClusters(
                in: base_path("modules/{$slug}/app/Filament/Clusters"),
                for: "Venture\\{$name}\\Filament\\Clusters",
            )
            ->discoverResources(
                in: base_path("modules/{$slug}/app/Filament/Resources"),
                for: "Venture\\{$name}\\Filament\\Resources",
            )
            ->discoverPages(
                in: base_path("modules/{$slug}/app/Filament/Pages"),
                for: "Venture\\{$name}\\Filament\\Pages",
            )
            ->discoverWidgets(
                in: base_path("modules/{$slug}/app/Filament/Widgets"),
                for: "Venture\\{$name}\\Filament\\Widgets",
            )
            ->discoverLivewireComponents(
                in: base_path("modules/{$slug}/app/Livewire"),
                for: "Venture\\{$name}\\Livewire",
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenantMiddleware([
                UpdateCurrentTeam::class,
                EnsureTeamAccess::class,
                EnsureTeamHasSubscription::with([
                    'slug' => $slug,
                ]),
                EnsureSingleTeamMode::class,
            ], isPersistent: true);
    }
}
