<?php

namespace Venture\Alpha\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class FilamentAssetServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $assets = Collection::make([
            Js::make('tailwindplus-elements', 'https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1')->module(),
            Js::make('mermaid', 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs')->module(),
        ]);

        if (File::exists(public_path('build/manifest.json'))) {
            $assets->push(Js::make('livewire-echo', Vite::asset('resources/js/livewire-echo.ts'))->module());
        }

        FilamentAsset::register($assets->toArray());
    }
}
