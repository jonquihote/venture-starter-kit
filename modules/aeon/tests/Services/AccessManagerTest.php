<?php

use Illuminate\Support\Collection;
use Venture\Aeon\Facades\Access;
use Venture\Aeon\Services\AccessManager;
use Venture\Aeon\Tests\Stubs\AccountPermissionsEnum;
use Venture\Aeon\Tests\Stubs\PagePermissionsEnum;
use Venture\Aeon\Tests\Stubs\RolesEnum;

beforeEach(function (): void {
    // Reset the AccessManager singleton between tests
    app()->forgetInstance(AccessManager::class);

    // Clear facade resolved instances to ensure fresh singleton
    Access::clearResolvedInstances();
});

describe('AccessManager Service', function (): void {
    it('starts with empty collections', function (): void {
        $manager = app(AccessManager::class);

        expect($manager->permissions())->toBeInstanceOf(Collection::class);
        expect($manager->permissions())->toBeEmpty();

        expect($manager->roles())->toBeInstanceOf(Collection::class);
        expect($manager->roles())->toBeEmpty();

        expect($manager->administratorRoles())->toBeInstanceOf(Collection::class);
        expect($manager->administratorRoles())->toBeEmpty();
    });

    it('adds permissions from single source', function (): void {
        $manager = app(AccessManager::class);
        $permissions = PagePermissionsEnum::all();

        $manager->addPermissions($permissions);

        expect($manager->permissions())->toHaveCount(4);
        expect($manager->permissions())->toEqual($permissions);
    });

    it('merges permissions from multiple sources', function (): void {
        $manager = app(AccessManager::class);
        $pagePermissions = PagePermissionsEnum::all();
        $accountPermissions = AccountPermissionsEnum::all();

        $manager->addPermissions($pagePermissions);
        $manager->addPermissions($accountPermissions);

        expect($manager->permissions())->toHaveCount(9); // 4 + 5
        expect($manager->permissions()->contains(PagePermissionsEnum::Dashboard))->toBeTrue();
        expect($manager->permissions()->contains(AccountPermissionsEnum::ViewAny))->toBeTrue();
    });

    it('adds roles from single source', function (): void {
        $manager = app(AccessManager::class);
        $roles = RolesEnum::all();

        $manager->addRoles($roles);

        expect($manager->roles())->toHaveCount(2);
        expect($manager->roles())->toEqual($roles);
    });

    it('merges roles from multiple sources', function (): void {
        $manager = app(AccessManager::class);

        // First module adds some roles
        $firstModuleRoles = Collection::make([
            'role1' => Collection::make([PagePermissionsEnum::Dashboard]),
            'role2' => Collection::make([AccountPermissionsEnum::ViewAny]),
        ]);

        // Second module adds different roles
        $secondModuleRoles = Collection::make([
            'role3' => Collection::make([PagePermissionsEnum::HorizonDashboard]),
            'role4' => Collection::make([AccountPermissionsEnum::Create]),
        ]);

        $manager->addRoles($firstModuleRoles);
        $manager->addRoles($secondModuleRoles);

        expect($manager->roles())->toHaveCount(4);
        expect($manager->roles()->has('role1'))->toBeTrue();
        expect($manager->roles()->has('role3'))->toBeTrue();
    });

    it('adds single administrator role', function (): void {
        $manager = app(AccessManager::class);

        $manager->addAdministratorRole(RolesEnum::Administrator);

        expect($manager->administratorRoles())->toHaveCount(1);
        expect($manager->administratorRoles()->first())->toBe(RolesEnum::Administrator);
    });

    it('prevents duplicate administrator role registration (idempotency)', function (): void {
        $manager = app(AccessManager::class);

        // Add the same administrator role multiple times
        $manager->addAdministratorRole(RolesEnum::Administrator);
        $manager->addAdministratorRole(RolesEnum::Administrator);
        $manager->addAdministratorRole(RolesEnum::Administrator);

        expect($manager->administratorRoles())->toHaveCount(1);
        expect($manager->administratorRoles()->contains(RolesEnum::Administrator))->toBeTrue();
    });

    it('maintains state as singleton', function (): void {
        $manager1 = app(AccessManager::class);
        $manager2 = app(AccessManager::class);

        expect($manager1)->toBe($manager2);

        // Add data through first instance
        $manager1->addPermissions(PagePermissionsEnum::all());
        $manager1->addAdministratorRole(RolesEnum::Administrator);

        // Verify it's available through second instance
        expect($manager2->permissions())->toHaveCount(4);
        expect($manager2->administratorRoles())->toHaveCount(1);
    });
});

describe('Access Facade', function (): void {
    it('provides static interface to AccessManager', function (): void {
        $permissions = PagePermissionsEnum::all();
        $roles = RolesEnum::all();

        Access::addPermissions($permissions);
        Access::addRoles($roles);
        Access::addAdministratorRole(RolesEnum::Administrator);

        expect(Access::permissions())->toHaveCount(4);
        expect(Access::roles())->toHaveCount(2);
        expect(Access::administratorRoles())->toHaveCount(1);
        expect(Access::administratorRoles()->first())->toBe(RolesEnum::Administrator);
    });

    it('works with direct service instance', function (): void {
        $manager = app(AccessManager::class);

        // Add via facade
        Access::addPermissions(PagePermissionsEnum::all());

        // Verify via service instance
        expect($manager->permissions())->toHaveCount(4);

        // Add via service instance
        $manager->addAdministratorRole(RolesEnum::User);

        // Verify via facade
        expect(Access::administratorRoles())->toHaveCount(1);
    });
});

describe('Multi-module simulation', function (): void {
    it('handles permissions from multiple modules correctly', function (): void {
        // Simulate Module A registering permissions
        Access::addPermissions(PagePermissionsEnum::only(
            PagePermissionsEnum::Dashboard,
            PagePermissionsEnum::HorizonDashboard,
        ));

        // Simulate Module B registering permissions
        Access::addPermissions(AccountPermissionsEnum::only(
            AccountPermissionsEnum::ViewAny,
            AccountPermissionsEnum::Create,
        ));

        // Simulate Module C registering permissions
        Access::addPermissions(PagePermissionsEnum::only(
            PagePermissionsEnum::PulseDashboard,
        ));

        $allPermissions = Access::permissions();
        expect($allPermissions)->toHaveCount(5);
        expect($allPermissions->contains(PagePermissionsEnum::Dashboard))->toBeTrue();
        expect($allPermissions->contains(AccountPermissionsEnum::ViewAny))->toBeTrue();
        expect($allPermissions->contains(PagePermissionsEnum::PulseDashboard))->toBeTrue();
    });

    it('handles roles from multiple modules correctly', function (): void {
        // Module A roles
        $moduleARoles = Collection::make([
            'module-a-admin' => PagePermissionsEnum::all(),
        ]);

        // Module B roles
        $moduleBRoles = Collection::make([
            'module-b-editor' => AccountPermissionsEnum::except(AccountPermissionsEnum::Delete),
            'module-b-viewer' => AccountPermissionsEnum::only(AccountPermissionsEnum::ViewAny),
        ]);

        Access::addRoles($moduleARoles);
        Access::addRoles($moduleBRoles);

        $allRoles = Access::roles();
        expect($allRoles)->toHaveCount(3);
        expect($allRoles->has('module-a-admin'))->toBeTrue();
        expect($allRoles->has('module-b-editor'))->toBeTrue();
        expect($allRoles->has('module-b-viewer'))->toBeTrue();
    });

    it('handles administrator roles from multiple modules correctly', function (): void {
        // Simulate Module A registering its admin role
        Access::addAdministratorRole(RolesEnum::Administrator);

        // Simulate Module B trying to register another admin role (same one - should be idempotent)
        Access::addAdministratorRole(RolesEnum::Administrator);

        $adminRoles = Access::administratorRoles();
        expect($adminRoles)->toHaveCount(1);
        expect($adminRoles->contains(RolesEnum::Administrator))->toBeTrue();
    });

    it('supports unique administrator roles per module concept', function (): void {
        $manager = app(AccessManager::class);

        // This test demonstrates the concept that each module should register one admin role
        // Even though our test enum only has Administrator, the system should support
        // multiple different administrator roles from different modules

        // Module registers its administrator role
        $manager->addAdministratorRole(RolesEnum::Administrator);

        // Attempting to register the same admin role again (idempotent)
        $manager->addAdministratorRole(RolesEnum::Administrator);

        expect($manager->administratorRoles())->toHaveCount(1);
        expect($manager->administratorRoles()->first())->toBe(RolesEnum::Administrator);
    });
});
