<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Venture\Aeon\Enums\ModulesEnum;
use Venture\Aeon\Support\Facades\Access;
use Venture\Home\Models\User;

use function Pest\Laravel\artisan;

pest()
    ->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\LazilyRefreshDatabase::class)
    ->beforeEach(function (): void {
        artisan('bootstrap');

        $this->user = User::factory()->create();
        $this->user->syncRoles(Access::administratorRoles());
    })
    ->in(__DIR__ . '/../modules/*/tests');

Collection::make(ModulesEnum::cases())
    ->each(function (ModulesEnum $module): void {
        pest()
            ->beforeEach(function () use ($module): void {
                Filament::setCurrentPanel(Filament::getPanel($module->slug()));
            })
            ->group($module->slug())
            ->in(__DIR__ . "/../modules/{$module->slug()}/tests");
    });

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
