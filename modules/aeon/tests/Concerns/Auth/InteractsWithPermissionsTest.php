<?php

use Illuminate\Support\Collection;
use Venture\Aeon\Tests\Stubs\PagePermissionsEnum;

it('returns all permissions as a collection of enum objects', function (): void {
    $result = PagePermissionsEnum::all();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(4);
    expect($result->toArray())->toEqual([
        PagePermissionsEnum::Dashboard,
        PagePermissionsEnum::HorizonDashboard,
        PagePermissionsEnum::PulseDashboard,
        PagePermissionsEnum::TelescopeDashboard,
    ]);
});

it('returns only specified permissions as enum objects', function (): void {
    $result = PagePermissionsEnum::only(PagePermissionsEnum::Dashboard);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(1);
    expect($result->first())->toBe(PagePermissionsEnum::Dashboard);
});

it('returns only multiple specified permissions as enum objects', function (): void {
    $result = PagePermissionsEnum::only(
        PagePermissionsEnum::Dashboard,
        PagePermissionsEnum::PulseDashboard
    );

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(2);
    expect($result->contains(PagePermissionsEnum::Dashboard))->toBeTrue();
    expect($result->contains(PagePermissionsEnum::PulseDashboard))->toBeTrue();
    expect($result->contains(PagePermissionsEnum::HorizonDashboard))->toBeFalse();
    expect($result->contains(PagePermissionsEnum::TelescopeDashboard))->toBeFalse();
});

it('returns all permissions except specified ones as enum objects', function (): void {
    $result = PagePermissionsEnum::except(PagePermissionsEnum::Dashboard);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(3);
    expect($result->contains(PagePermissionsEnum::Dashboard))->toBeFalse();
    expect($result->contains(PagePermissionsEnum::HorizonDashboard))->toBeTrue();
    expect($result->contains(PagePermissionsEnum::PulseDashboard))->toBeTrue();
    expect($result->contains(PagePermissionsEnum::TelescopeDashboard))->toBeTrue();
});

it('returns all permissions except multiple specified ones as enum objects', function (): void {
    $result = PagePermissionsEnum::except(
        PagePermissionsEnum::Dashboard,
        PagePermissionsEnum::PulseDashboard
    );

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(2);
    expect($result->contains(PagePermissionsEnum::Dashboard))->toBeFalse();
    expect($result->contains(PagePermissionsEnum::PulseDashboard))->toBeFalse();
    expect($result->contains(PagePermissionsEnum::HorizonDashboard))->toBeTrue();
    expect($result->contains(PagePermissionsEnum::TelescopeDashboard))->toBeTrue();
});

it('returns empty collection when only is called with non-existent permission', function (): void {
    // This test ensures the trait gracefully handles edge cases
    $result = PagePermissionsEnum::only();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toBeEmpty();
});

it('returns all permissions when except is called with non-existent permission', function (): void {
    // This test ensures the trait gracefully handles edge cases
    $result = PagePermissionsEnum::except();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(4);
});
