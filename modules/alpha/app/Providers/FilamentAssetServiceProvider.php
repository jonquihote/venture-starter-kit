<?php

namespace Venture\Alpha\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class FilamentAssetServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('livewire-echo', Vite::asset('resources/js/livewire-echo.ts'))->module(),
            Js::make('mermaid', 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs')->module(),
        ]);
    }
}
