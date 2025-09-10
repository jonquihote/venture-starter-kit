<?php

use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;
use Venture\Aeon\Facades\Access;
use Venture\Alpha\Enums\Auth\RolesEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\AccountCredential;
use Venture\Alpha\Models\Application;
use Venture\Alpha\Models\Subscription;
use Venture\Alpha\Models\Team;

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
        artisan('aeon:init:access');
        artisan('alpha:init:engine');
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
                $this->currentAccount = Account::factory()
                    ->has(AccountCredential::factory()->username(), 'credentials')
                    ->has(AccountCredential::factory()->email(), 'credentials')
                    ->create();

                $this->currentTeam = Team::factory()->for($this->currentAccount, 'owner')->create();

                $this->currentAccount
                    ->forceFill([
                        'current_team_id' => $this->currentTeam->id,
                    ])
                    ->save();

                if ($slug === 'alpha') {
                    $this->application = Application::query()
                        ->where('slug', $slug)
                        ->first();

                    $this->subscription = Subscription::factory()->create([
                        'team_id' => $this->currentTeam->id,
                        'application_id' => $this->application->id,
                    ]);

                    setPermissionsTeamId($this->currentTeam->id);

                    $roles = Access::administratorRoles()
                        ->reject(function (BackedEnum $role) {
                            return $role === RolesEnum::Administrator;
                        })
                        ->push(RolesEnum::SuperAdministrator);

                    $this->currentAccount->syncRoles($roles);
                }

                actingAs($this->currentAccount);

                Filament::setTenant($this->currentTeam);
                Filament::setCurrentPanel(Filament::getPanel($slug));
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
