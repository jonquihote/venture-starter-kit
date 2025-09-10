<?php

use Venture\Home\Filament\Widgets\ActiveApplicationsOverview;

use function Pest\Livewire\livewire;

describe('ActiveApplicationsOverview Widget', function (): void {
    it('can load the widget', function (): void {
        livewire(ActiveApplicationsOverview::class)
            ->assertOk();
    });
});
