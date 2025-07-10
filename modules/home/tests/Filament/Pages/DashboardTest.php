<?php

use Venture\Home\Filament\Pages\Dashboard;

use function Pest\Laravel\actingAs;

it('can render dashboard', function (): void {
    $response = actingAs($this->user)
        ->get(Dashboard::getUrl());

    $response->assertOk();
});
