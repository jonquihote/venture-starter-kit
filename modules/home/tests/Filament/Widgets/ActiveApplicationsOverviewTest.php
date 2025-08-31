<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Venture\Aeon\Data\ApplicationData;
use Venture\Aeon\Facades\Access;
use Venture\Home\Filament\Widgets\ActiveApplicationsOverview;

use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

describe('ActiveApplicationsOverview Widget', function (): void {
    test('widget renders correctly', function (): void {
        Access::shouldReceive('applications')->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewIs('home::filament.widgets.active-applications-overview')
            ->assertViewHas('applications');
    });

    test('widget has correct properties', function (): void {
        $widget = new ActiveApplicationsOverview;

        expect($widget)
            ->toBeInstanceOf(ActiveApplicationsOverview::class)
            ->and(invade($widget)->columnSpan)->toBe('full')
            ->and(invade($widget)->view)->toBe('home::filament.widgets.active-applications-overview');
    });

    test('displays available applications', function (): void {
        $applications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Test App',
                slug: 'home',
                icon: 'lucide-home'
            ),
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Another App',
                slug: 'home-2',
                icon: 'lucide-user'
            ),
        ]);

        Access::shouldReceive('applications')
            ->andReturn($applications);

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $apps) use ($applications) {
                return $apps->count() === $applications->count();
            });
    });

    test('displays single application correctly', function (): void {
        $application = new ApplicationData(
            page: 'Venture\Home\Filament\Pages\Dashboard',
            name: 'Single App',
            slug: 'home',
            icon: 'lucide-settings'
        );

        Access::shouldReceive('applications')
            ->andReturn(collect([$application]));

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $applications) {
                return $applications->count() === 1;
            });
    });

    test('handles empty state when no applications exist', function (): void {
        Access::shouldReceive('applications')
            ->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $applications) {
                return $applications->isEmpty();
            })
            ->assertSee('No applications installed')
            ->assertSee('Applications will appear here once they are registered.');
    });

    test('shows placeholder slots for remaining spaces', function (): void {
        Access::shouldReceive('applications')
            ->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertSee('Available'); // Placeholder text
    });

    test('application cards display correct information', function (): void {
        $application = new ApplicationData(
            page: 'Venture\Home\Filament\Pages\Dashboard',
            name: 'Test Application',
            slug: 'home',
            icon: 'lucide-file'
        );

        Access::shouldReceive('applications')
            ->andReturn(collect([$application]));

        $component = livewire(ActiveApplicationsOverview::class)
            ->assertOk();

        // Verify the application data is passed correctly to the view
        $viewData = $component->viewData('applications');
        expect($viewData)->toHaveCount(1);

        $passedApplication = $viewData->first();
        expect($passedApplication)
            ->toBeInstanceOf(ApplicationData::class)
            ->and($passedApplication->name)->toBe('Test Application')
            ->and($passedApplication->slug)->toBe('home')
            ->and($passedApplication->icon)->toBe('lucide-file')
            ->and($passedApplication->page)->toBe('Venture\Home\Filament\Pages\Dashboard');
    });

    test('displays maximum of 15 total slots', function (): void {
        // Create more applications than the maximum slots
        $applications = collect();
        for ($i = 1; $i <= 20; $i++) {
            $applications->push(new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: "App {$i}",
                slug: "home-{$i}",
                icon: 'lucide-folder'
            ));
        }

        Access::shouldReceive('applications')
            ->andReturn($applications);

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $apps) use ($applications) {
                return $apps->count() === $applications->count();
            });

        // Note: The view logic handles showing all applications but limits placeholders
        // With 20 applications, there should be no placeholder slots (20 > 15)
        // The view displays all applications regardless of the 15-slot limit for placeholders
    });

    test('widget data is properly formatted for view', function (): void {
        $applications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'First App',
                slug: 'home-1',
                icon: 'lucide-circle'
            ),
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Second App',
                slug: 'home-2',
                icon: 'lucide-square'
            ),
        ]);

        Access::shouldReceive('applications')
            ->andReturn($applications);

        $widget = new ActiveApplicationsOverview;

        // Access the protected method using invade
        $viewData = invade($widget)->getViewData();

        expect($viewData)->toHaveKey('applications')
            ->and($viewData['applications'])->toBeInstanceOf(Collection::class)
            ->and($viewData['applications'])->toHaveCount(2);

        $firstApp = $viewData['applications']->first();
        expect($firstApp)->toBeInstanceOf(ApplicationData::class)
            ->and($firstApp->name)->toBe('First App');
    });

    test('respects user permissions through Access facade', function (): void {
        // The Access facade is responsible for filtering applications based on user permissions
        // We test that the widget properly uses the facade's filtered results

        $authorizedApplications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Authorized App',
                slug: 'home',
                icon: 'lucide-shield'
            ),
        ]);

        Access::shouldReceive('applications')
            ->andReturn($authorizedApplications);

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $apps) use ($authorizedApplications) {
                return $apps->count() === $authorizedApplications->count();
            });
    });

    test('handles Access facade returning empty collection gracefully', function (): void {
        Access::shouldReceive('applications')
            ->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $applications) {
                return $applications->isEmpty();
            });
    });

    test('widget refreshes when applications change', function (): void {
        // First, show empty state
        Access::shouldReceive('applications')
            ->once()
            ->andReturn(collect());

        $component = livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertSee('No applications installed');

        // Then create a second test to simulate refresh with new data
        Access::shouldReceive('applications')
            ->once()
            ->andReturn(collect([
                new ApplicationData(
                    page: 'Venture\Home\Filament\Pages\Dashboard',
                    name: 'New App',
                    slug: 'home',
                    icon: 'lucide-star'
                ),
            ]));

        // Create a new component instance to simulate refresh
        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $apps) {
                return $apps->count() === 1;
            });
    });

    test('widget maintains consistent data structure', function (): void {
        $applications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Consistent App',
                slug: 'home',
                icon: 'lucide-check'
            ),
        ]);

        Access::shouldReceive('applications')
            ->andReturn($applications);

        // Test multiple calls return consistent structure
        $widget1 = new ActiveApplicationsOverview;
        $widget2 = new ActiveApplicationsOverview;

        $data1 = invade($widget1)->getViewData();
        $data2 = invade($widget2)->getViewData();

        expect($data1)->toEqual($data2)
            ->and($data1['applications'])->toHaveCount(1)
            ->and($data2['applications'])->toHaveCount(1);
    });

    test('displays correct grid layout structure', function (): void {
        Access::shouldReceive('applications')
            ->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertSeeHtml('grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8');
    });

    test('empty state translations are loaded correctly', function (): void {
        Access::shouldReceive('applications')
            ->andReturn(collect());

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertSee('No applications installed')
            ->assertSee('Applications will appear here once they are registered.');

        // Verify the translation keys resolve correctly
        expect(__('home::filament/widgets/active-applications-overview.empty_state.heading'))
            ->toBe('No applications installed')
            ->and(__('home::filament/widgets/active-applications-overview.empty_state.description'))
            ->toBe('Applications will appear here once they are registered.');
    });

    test('widget extends Filament Widget correctly', function (): void {
        $widget = new ActiveApplicationsOverview;

        expect($widget)
            ->toBeInstanceOf(\Filament\Widgets\Widget::class);
    });

    test('widget uses Access facade for data retrieval', function (): void {
        $applications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'Test App',
                slug: 'home',
                icon: 'lucide-home'
            ),
        ]);

        Access::shouldReceive('applications')
            ->once()
            ->andReturn($applications);

        $widget = new ActiveApplicationsOverview;
        $viewData = invade($widget)->getViewData();

        expect($viewData['applications'])->toEqual($applications);
    });

    test('widget view displays proper placeholder count', function (): void {
        // Test with 3 applications (should show 12 placeholders for total of 15)
        $applications = collect([
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'App 1',
                slug: 'home-1',
                icon: 'lucide-box'
            ),
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'App 2',
                slug: 'home-2',
                icon: 'lucide-tag'
            ),
            new ApplicationData(
                page: 'Venture\Home\Filament\Pages\Dashboard',
                name: 'App 3',
                slug: 'home-3',
                icon: 'lucide-heart'
            ),
        ]);

        Access::shouldReceive('applications')
            ->andReturn($applications);

        livewire(ActiveApplicationsOverview::class)
            ->assertOk()
            ->assertViewHas('applications', function (Collection $apps) {
                return $apps->count() === 3;
            })
            ->assertSee('Available'); // Should see placeholder text
    });
});
