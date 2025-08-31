<?php

use Venture\Home\Filament\Pages\Dashboard;

use function Pest\Livewire\livewire;

test('dashboard page renders successfully', function (): void {
    livewire(Dashboard::class)
        ->assertOk();
});
