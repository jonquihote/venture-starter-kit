<?php

use Sprout\Listeners\CleanupServiceOverrides;
use Sprout\Listeners\PerformIdentityResolverSetup;
use Sprout\Listeners\RefreshTenantAwareDependencies;
use Sprout\Listeners\SetCurrentTenantContext;
use Sprout\Listeners\SetupServiceOverrides;
use Sprout\Support\ResolutionHook;

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled hooks
    |--------------------------------------------------------------------------
    |
    | This value contains an array of resolution hooks that should be enabled.
    | The handling of each hook is different, but if a hook is missing from
    | here, some things, such as listeners, may not be registered.
    |
    */

    'hooks' => [
        // \Sprout\Support\ResolutionHook::Booting,
        ResolutionHook::Routing,
        ResolutionHook::Middleware,
    ],

    /*
    |--------------------------------------------------------------------------
    | The event listeners used to bootstrap a tenancy
    |--------------------------------------------------------------------------
    |
    | This value contains all the listeners that should be run for the
    | \Sprout\Events\CurrentTenantChanged event to bootstrap a tenancy.
    |
    */

    'bootstrappers' => [
        // Set the current tenant within the Laravel context
        SetCurrentTenantContext::class,
        // Calls the setup method on the current identity resolver
        PerformIdentityResolverSetup::class,
        // Performs any clean-up from the previous tenancy
        CleanupServiceOverrides::class,
        // Sets up service overrides for the current tenancy
        SetupServiceOverrides::class,
        // Refresh anything that's tenant-aware
        RefreshTenantAwareDependencies::class,
    ],

];
