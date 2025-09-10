<?php

declare(strict_types=1);

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Venture\Aeon\Concerns\InteractsWithNotifications;
use Venture\Alpha\Concerns\InteractsWithFilamentUser;
use Venture\Alpha\Database\Factories\AccountFactory;
use Venture\Alpha\Enums\MigrationsEnum;
use Venture\Alpha\Models\Account;
use Venture\Alpha\Models\Account\Concerns\ConfiguresActivityLog;
use Venture\Alpha\Models\Account\Concerns\InteractsWithCredentials;
use Venture\Alpha\Models\Account\Concerns\InteractsWithTeams;
use Venture\Alpha\Models\Account\Events\AccountCreated;
use Venture\Alpha\Models\Account\Events\AccountCreating;
use Venture\Alpha\Models\Account\Events\AccountDeleted;
use Venture\Alpha\Models\Account\Events\AccountDeleting;
use Venture\Alpha\Models\Account\Events\AccountReplicating;
use Venture\Alpha\Models\Account\Events\AccountRetrieved;
use Venture\Alpha\Models\Account\Events\AccountSaved;
use Venture\Alpha\Models\Account\Events\AccountSaving;
use Venture\Alpha\Models\Account\Events\AccountUpdated;
use Venture\Alpha\Models\Account\Events\AccountUpdating;
use Venture\Alpha\Models\Account\Observers\AccountObserver;
use Venture\Alpha\Models\AccountCredential;

use function Pest\Laravel\assertDatabaseHas;

describe('Account Model', function (): void {
    describe('Class Hierarchy', function (): void {
        it('extends Authenticatable', function (): void {
            $account = new Account;
            expect($account)->toBeInstanceOf(Authenticatable::class);
        });

        it('implements FilamentUser interface', function (): void {
            $account = new Account;
            expect($account)->toBeInstanceOf(FilamentUser::class);
        });

        it('implements HasDefaultTenant interface', function (): void {
            $account = new Account;
            expect($account)->toBeInstanceOf(HasDefaultTenant::class);
        });

        it('implements HasTenants interface', function (): void {
            $account = new Account;
            expect($account)->toBeInstanceOf(HasTenants::class);
        });

        it('has UseFactory attribute properly configured', function (): void {
            $reflection = new ReflectionClass(Account::class);
            $attributes = $reflection->getAttributes(UseFactory::class);

            expect($attributes)->toHaveCount(1);
            expect($attributes[0]->getArguments())->toEqual([AccountFactory::class]);
        });

        it('has ObservedBy attribute properly configured', function (): void {
            $reflection = new ReflectionClass(Account::class);
            $attributes = $reflection->getAttributes(ObservedBy::class);

            expect($attributes)->toHaveCount(1);
            expect($attributes[0]->getArguments())->toEqual([[AccountObserver::class]]);
        });
    });

    describe('Trait Usage', function (): void {
        it('uses HasFactory trait', function (): void {
            expect(in_array('Illuminate\Database\Eloquent\Factories\HasFactory', class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses HasRoles trait', function (): void {
            expect(in_array(HasRoles::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses CausesActivity trait', function (): void {
            expect(in_array(CausesActivity::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses LogsActivity trait', function (): void {
            expect(in_array(LogsActivity::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses Searchable trait', function (): void {
            expect(in_array(Searchable::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses InteractsWithCredentials trait', function (): void {
            expect(in_array(InteractsWithCredentials::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses InteractsWithFilamentUser trait', function (): void {
            expect(in_array(InteractsWithFilamentUser::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses InteractsWithTeams trait', function (): void {
            expect(in_array(InteractsWithTeams::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses InteractsWithNotifications trait', function (): void {
            expect(in_array(InteractsWithNotifications::class, class_uses(Account::class)))
                ->toBeTrue();
        });

        it('uses ConfiguresActivityLog trait', function (): void {
            expect(in_array(ConfiguresActivityLog::class, class_uses(Account::class)))
                ->toBeTrue();
        });
    });

    describe('Model Configuration', function (): void {
        it('has correct fillable fields', function (): void {
            $account = new Account;

            expect($account->getFillable())->toEqual([
                'current_team_id',
                'name',
                'password',
            ]);
        });

        it('has correct hidden fields', function (): void {
            $account = new Account;

            expect($account->getHidden())->toEqual([
                'password',
                'remember_token',
            ]);
        });

        it('has factory properly configured', function (): void {
            $account = Account::factory()->make();

            expect($account)->toBeInstanceOf(Account::class);
            expect($account->name)->toBeString();
            expect($account->password)->toBeString();
        });

        it('can create account with factory', function (): void {
            $account = Account::factory()->create([
                'name' => 'Test User',
                'password' => 'test-password',
            ]);

            expect($account->exists)->toBeTrue();
            expect($account->name)->toBe('Test User');
            expect(Hash::check('test-password', $account->password))->toBeTrue();
        });
    });

    describe('Casts', function (): void {
        it('casts password to hashed', function (): void {
            $account = new Account;
            $casts = $account->getCasts();

            expect($casts)->toHaveKey('password');
            expect($casts['password'])->toBe('hashed');
        });

        it('automatically hashes password when set', function (): void {
            $account = Account::factory()->create([
                'name' => 'Test User',
                'password' => 'plain-password',
            ]);

            // The password should be hashed, not plain text
            expect($account->password)->not->toBe('plain-password');
            expect(Hash::check('plain-password', $account->password))->toBeTrue();
        });

        it('handles password updates correctly', function (): void {
            $account = Account::factory()->create([
                'password' => 'original-password',
            ]);

            $originalHash = $account->password;

            // Update password
            $account->update(['password' => 'new-password']);

            expect($account->password)->not->toBe($originalHash);
            expect($account->password)->not->toBe('new-password');
            expect(Hash::check('new-password', $account->password))->toBeTrue();
            expect(Hash::check('original-password', $account->password))->toBeFalse();
        });
    });

    describe('Database Table', function (): void {
        it('getTable() returns correct table name', function (): void {
            $account = new Account;

            expect($account->getTable())->toBe('alpha_accounts');
            expect($account->getTable())->toBe(MigrationsEnum::Accounts->table());
        });

        it('uses correct table for database operations', function (): void {
            $account = Account::factory()->create();

            // Verify the record exists in the correct table using Laravel's assertDatabaseHas
            assertDatabaseHas('alpha_accounts', [
                'id' => $account->id,
                'name' => $account->name,
            ]);
        });
    });

    describe('Searchable Configuration', function (): void {
        it('toSearchableArray returns correct structure with credentials', function (): void {
            // Create account with credentials
            $account = Account::factory()->create(['name' => 'Searchable User']);

            // Create credentials using the relationship
            AccountCredential::factory()->email('search@example.com')->create([
                'account_id' => $account->id,
                'is_primary' => true,
            ]);

            AccountCredential::factory()->username('searchuser')->create([
                'account_id' => $account->id,
                'is_primary' => true,
            ]);

            // Refresh to load relationships
            $account->refresh();

            $searchableArray = $account->toSearchableArray();

            expect($searchableArray)->toHaveKey('id');
            expect($searchableArray)->toHaveKey('name');
            expect($searchableArray)->toHaveKey('username');
            expect($searchableArray)->toHaveKey('email');

            expect($searchableArray['id'])->toBe($account->id);
            expect($searchableArray['name'])->toBe('Searchable User');
            expect($searchableArray['username'])->toBe('searchuser');
            expect($searchableArray['email'])->toBe('search@example.com');
        });

        it('handles missing credentials gracefully in toSearchableArray', function (): void {
            // Create account without credentials
            $account = Account::factory()->create(['name' => 'No Credentials User']);

            // This should throw an error when credentials are missing
            // since the current implementation expects username and email to exist
            expect(function () use ($account): void {
                $account->toSearchableArray();
            })->toThrow(Exception::class);
        });

        it('can be added to search index', function (): void {
            $account = Account::factory()->create(['name' => 'Search Index User']);

            // Verify account has searchable trait methods
            expect(method_exists($account, 'searchableAs'))->toBeTrue();
            expect(method_exists($account, 'toSearchableArray'))->toBeTrue();
            expect(method_exists($account, 'getScoutKey'))->toBeTrue();
        });
    });

    describe('Event Dispatching Configuration', function (): void {
        it('has correct dispatchesEvents array', function (): void {
            // Test event dispatching by creating and triggering events
            Event::fake();

            $account = Account::factory()->create([
                'name' => 'Event Test User',
                'password' => 'test-password',
            ]);

            // Test updating to trigger events
            $account->update(['name' => 'Updated Name']);

            // Verify events are properly configured by checking they were dispatched
            Event::assertDispatched(AccountCreated::class);
            Event::assertDispatched(AccountUpdated::class);
        });

        it('has all required event classes available', function (): void {
            expect(class_exists(AccountRetrieved::class))->toBeTrue();
            expect(class_exists(AccountCreating::class))->toBeTrue();
            expect(class_exists(AccountCreated::class))->toBeTrue();
            expect(class_exists(AccountUpdating::class))->toBeTrue();
            expect(class_exists(AccountUpdated::class))->toBeTrue();
            expect(class_exists(AccountSaving::class))->toBeTrue();
            expect(class_exists(AccountSaved::class))->toBeTrue();
            expect(class_exists(AccountDeleting::class))->toBeTrue();
            expect(class_exists(AccountDeleted::class))->toBeTrue();
            expect(class_exists(AccountReplicating::class))->toBeTrue();
        });

        it('dispatches all lifecycle events correctly', function (): void {
            Event::fake();

            // Test creating events
            $account = Account::factory()->create([
                'name' => 'Lifecycle Test User',
                'password' => 'test-password',
            ]);

            // Test updating events
            $account->update(['name' => 'Updated Name']);

            // Test deleting events
            $account->delete();

            // Verify key lifecycle events were dispatched
            Event::assertDispatched(AccountCreating::class);
            Event::assertDispatched(AccountCreated::class);
            Event::assertDispatched(AccountSaving::class);
            Event::assertDispatched(AccountSaved::class);
            Event::assertDispatched(AccountUpdating::class);
            Event::assertDispatched(AccountUpdated::class);
            Event::assertDispatched(AccountDeleting::class);
            Event::assertDispatched(AccountDeleted::class);
        });
    });

    describe('Model Integration', function (): void {
        it('works with all configured traits and interfaces', function (): void {
            $account = Account::factory()->create([
                'name' => 'Integration Test User',
                'password' => 'integration-password',
            ]);

            // Test HasFactory integration
            expect($account)->toBeInstanceOf(Account::class);
            expect($account->exists)->toBeTrue();

            // Test Authenticatable integration
            expect($account->getAuthIdentifierName())->toBe('id');
            expect($account->getAuthIdentifier())->toBe($account->id);

            // Test password hashing integration
            expect(Hash::check('integration-password', $account->password))->toBeTrue();

            // Test basic model functionality
            expect($account->name)->toBe('Integration Test User');
            expect($account->getTable())->toBe('alpha_accounts');
        });

        it('can be used with Eloquent queries', function (): void {
            $account1 = Account::factory()->create(['name' => 'Query Test 1']);
            $account2 = Account::factory()->create(['name' => 'Query Test 2']);

            $foundAccounts = Account::where('name', 'like', 'Query Test%')->get();

            expect($foundAccounts)->toHaveCount(2);
            expect($foundAccounts->pluck('name')->toArray())->toContain('Query Test 1');
            expect($foundAccounts->pluck('name')->toArray())->toContain('Query Test 2');
        });

        it('maintains data integrity with fillable and hidden fields', function (): void {
            $account = Account::factory()->create([
                'name' => 'Data Integrity Test',
                'password' => 'secret-password',
            ]);

            // Test hidden fields are not included in array/json
            $accountArray = $account->toArray();
            expect($accountArray)->not->toHaveKey('password');
            expect($accountArray)->not->toHaveKey('remember_token');

            // Test fillable fields can be mass assigned
            $account->fill([
                'name' => 'Updated Name',
                'current_team_id' => 1,
                'password' => 'new-password',
            ]);

            expect($account->name)->toBe('Updated Name');
            expect($account->current_team_id)->toBe(1);
        });
    });
});
