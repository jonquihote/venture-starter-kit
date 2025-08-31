<?php

declare(strict_types=1);

use Spatie\Permission\Models\Role;
use Venture\Home\Enums\Auth\RolesEnum;
use Venture\Home\Models\Account;
use Venture\Home\Models\Account\Observers\AccountObserver;

beforeEach(function (): void {
    // Ensure User role exists
    Role::firstOrCreate(['name' => RolesEnum::User->value]);
});

describe('AccountObserver', function (): void {
    test('is properly registered with Account model', function (): void {
        $account = Account::factory()->create();

        // Check that observer is registered by verifying events are handled
        expect($account->getRoleNames())->toContain(RolesEnum::User->value);
    });

    test('assigns default User role on account creation', function (): void {
        $account = Account::factory()->create();

        expect($account->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account->getRoleNames())->toContain(RolesEnum::User->value);
    });

    test('role assignment happens after account is created', function (): void {
        $account = Account::factory()->create();

        // Verify account exists in database
        expect($account->exists)->toBeTrue()
            ->and($account->id)->not->toBeNull()
            ->and($account->hasRole(RolesEnum::User))->toBeTrue();
    });

    test('only assigns User role by default', function (): void {
        // Create additional roles to ensure only User is assigned
        Role::firstOrCreate(['name' => RolesEnum::Administrator->value]);

        $account = Account::factory()->create();

        expect($account->getRoleNames())->toHaveCount(1)
            ->and($account->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account->hasRole(RolesEnum::Administrator))->toBeFalse();
    });

    test('role assignment works for multiple accounts', function (): void {
        $account1 = Account::factory()->create();
        $account2 = Account::factory()->create();
        $account3 = Account::factory()->create();

        expect($account1->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account2->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account3->hasRole(RolesEnum::User))->toBeTrue();
    });

    test('observer methods exist and are callable', function (): void {
        $observer = new AccountObserver;
        $account = Account::factory()->make();

        // Test that all observer methods exist
        expect(method_exists($observer, 'retrieved'))->toBeTrue()
            ->and(method_exists($observer, 'creating'))->toBeTrue()
            ->and(method_exists($observer, 'created'))->toBeTrue()
            ->and(method_exists($observer, 'updating'))->toBeTrue()
            ->and(method_exists($observer, 'updated'))->toBeTrue()
            ->and(method_exists($observer, 'saving'))->toBeTrue()
            ->and(method_exists($observer, 'saved'))->toBeTrue()
            ->and(method_exists($observer, 'deleting'))->toBeTrue()
            ->and(method_exists($observer, 'deleted'))->toBeTrue()
            ->and(method_exists($observer, 'replicating'))->toBeTrue();

        // Test that methods can be called without errors
        $observer->retrieved($account);
        $observer->creating($account);
        $observer->updating($account);
        $observer->updated($account);
        $observer->saving($account);
        $observer->saved($account);
        $observer->deleting($account);
        $observer->deleted($account);
        $observer->replicating($account);

        expect(true)->toBeTrue(); // If we get here, no exceptions were thrown
    });

    test('created method assigns role correctly', function (): void {
        $observer = new AccountObserver;
        $account = Account::factory()->create();

        // Clear roles and manually call observer method
        $account->syncRoles([]);
        expect($account->getRoleNames())->toHaveCount(0);

        // Manually call the created method
        $observer->created($account);

        // Refresh account to get updated roles
        $account->refresh();

        expect($account->hasRole(RolesEnum::User))->toBeTrue();
    });

    test('role assignment is idempotent', function (): void {
        $observer = new AccountObserver;
        $account = Account::factory()->create();

        // Should already have User role from creation
        expect($account->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account->getRoleNames())->toHaveCount(1);

        // Call created method again
        $observer->created($account);

        // Should still only have one User role
        expect($account->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account->getRoleNames())->toHaveCount(1);
    });

    test('observer handles role assignment when role already exists', function (): void {
        $account = Account::factory()->create();

        // Manually assign User role
        $account->assignRole(RolesEnum::User);
        expect($account->getRoleNames())->toHaveCount(1);

        // Create another account - observer should still work
        $account2 = Account::factory()->create();

        expect($account2->hasRole(RolesEnum::User))->toBeTrue()
            ->and($account2->getRoleNames())->toHaveCount(1);
    });
});

describe('Observer Integration', function (): void {
    test('observer is triggered during model events', function (): void {
        // Don't fake events since we need the observer to run
        $account = Account::factory()->create();

        // Verify account was created and role assigned
        expect($account->hasRole(RolesEnum::User))->toBeTrue();
    });

    test('observer works with factory default', function (): void {
        $account = Account::factory()->create();

        expect($account->hasRole(RolesEnum::User))->toBeTrue();
    });

    test('observer persists role assignment', function (): void {
        $account = Account::factory()->create();
        $accountId = $account->id;

        // Clear model from memory and reload fresh instance
        unset($account);
        $freshAccount = Account::find($accountId);

        expect($freshAccount->hasRole(RolesEnum::User))->toBeTrue();
    });
});
