<?php

use Filament\Facades\Filament;
use Venture\Alpha\Models\Team;
use Venture\Home\Filament\Widgets\ActiveApplicationsOverview;

use function Pest\Livewire\livewire;

describe('ActiveApplicationsOverview Widget', function (): void {
    beforeEach(function (): void {
        // Create a team for the authenticated user
        $this->team = Team::factory()->create([
            'owner_id' => $this->account->id,
        ]);

        // Set the team as current tenant
        Filament::setTenant($this->team);
    });

    it('can load the widget', function (): void {
        livewire(ActiveApplicationsOverview::class)
            ->assertOk();
    });
});
