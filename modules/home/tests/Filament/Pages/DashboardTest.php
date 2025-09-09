<?php

use Venture\Home\Filament\Pages\Dashboard;

use function Pest\Livewire\livewire;

describe('Dashboard Page', function (): void {
    it('can load the dashboard page', function (): void {
        livewire(Dashboard::class)
            ->assertOk();
    });

    it('displays correct title from translation', function (): void {
        livewire(Dashboard::class)
            ->assertSee(__('home::filament/pages/dashboard.title'));
    });

    it('has correct navigation label', function (): void {
        expect(Dashboard::getNavigationLabel())
            ->toBe(__('home::filament/pages/dashboard.navigation.label'));
    });

    it('uses correct navigation icon', function (): void {
        expect(Dashboard::getNavigationIcon())
            ->toBe('lucide-house');
    });

    it('returns correct page title', function (): void {
        $dashboard = new Dashboard;

        expect($dashboard->getTitle())
            ->toBe(__('home::filament/pages/dashboard.title'));
    });
});
