<?php

namespace Venture\Alpha\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FilamentViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $collection = Collection::make([
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER => Collection::make([
                'alpha::filament.render-hooks.HOOK_NAME.login-links',
            ]),
        ]);

        $collection
            ->each(function (Collection $views, string $hook): void {
                $views = $views->map(function (string $view) use ($hook) {
                    return Str::replace('HOOK_NAME', $this->getHookName($hook), $view);
                });

                $views->each(function (string $view) use ($hook): void {
                    FilamentView::registerRenderHook($hook, function () use ($view): View {
                        return view($view);
                    });
                });
            });
    }

    protected function getHookName(string $hookName): string
    {
        return Str::of($hookName)
            ->replace('.', '-')
            ->replace('::', '.')
            ->toString();
    }
}
