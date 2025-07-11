<?php

namespace Venture\Aeon\Actions;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Lorisleiva\Actions\Action;
use Venture\Aeon\Enums\ModulesEnum;

class InitializeFilamentPanel extends Action
{
    public function handle(Panel $panel, ModulesEnum $module)
    {
        $name = $module->name();
        $slug = $module->slug();

        return $panel
            ->id($slug)
            ->path($slug)
            ->viteTheme('resources/css/app.css')
            ->topNavigation()
            ->homeUrl(function () {
                return route('filament.home.pages.dashboard');
            })
            ->userMenuItems([
                'logout' => MenuItem::make()->url(function () {
                    return route('filament.home.auth.logout');
                }),
            ])
            ->databaseNotifications()
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
            ->discoverClusters(
                in: base_path("modules/{$slug}/app/Filament/Clusters"),
                for: "Venture\\{$name}\\Filament\\Clusters",
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
            ]);
    }
}
