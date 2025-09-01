<?php

use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;
use Venture\Aeon\Facades\Access;
use Venture\Home\Models\Account;
use Venture\Home\Models\AccountCredential;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\artisan;

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

pest()
    ->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(function (): void {
        artisan('aeon:bootstrap:authorization');
    })
    ->in(
        __DIR__ . '/../modules/*/tests',
        __DIR__ . '/../modules/*/tests-api',
    );

Collection::make(json_decode(file_get_contents(__DIR__ . '/../modules_statuses.json'), true))
    ->filter()
    ->keys()
    ->reject(function (string $value): bool {
        return in_array($value, [
            'Aeon',
        ]);
    })
    ->values()
    ->each(function (string $module): void {
        $slug = Str::slug($module);

        pest()
            ->beforeEach(function () use ($slug): void {
                Filament::setCurrentPanel(Filament::getPanel($slug));

                $this->account = Account::factory()
                    ->has(AccountCredential::factory()->username(), 'credentials')
                    ->has(AccountCredential::factory()->email(), 'credentials')
                    ->create();

                $this->account->syncRoles(Access::administratorRoles());

                actingAs($this->account);
            })
            ->group($slug)
            ->in(
                __DIR__ . "/../modules/{$slug}/tests",
                __DIR__ . "/../modules/{$slug}/tests-api",
            );
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
