<?php

use Sprout\Overrides\AuthGuardOverride;
use Sprout\Overrides\AuthPasswordOverride;
use Sprout\Overrides\CacheOverride;
use Sprout\Overrides\CookieOverride;
use Sprout\Overrides\FilesystemManagerOverride;
use Sprout\Overrides\FilesystemOverride;
use Sprout\Overrides\JobOverride;
use Sprout\Overrides\SessionOverride;
use Sprout\Overrides\StackedOverride;

/*
|--------------------------------------------------------------------------
| Service Overrides
|--------------------------------------------------------------------------
|
| This config file provides the config for the different service overrides
| registered by Sprout.
| Service overrides are registered against a "service", which is an arbitrary
| string value, used to prevent multiple overrides for a single service.
|
| All service overrides should have a "driver" which should contain an FQN
| for a class that implements the ServiceOverride interface.
| Any other config options will depend on the individual service override
| driver.
|
*/

return [

    'filesystem' => [
        'driver' => StackedOverride::class,
        'overrides' => [
            FilesystemManagerOverride::class,
            FilesystemOverride::class,
        ],
    ],

    'job' => [
        'driver' => JobOverride::class,
    ],

    'cache' => [
        'driver' => CacheOverride::class,
    ],

    'auth' => [
        'driver' => StackedOverride::class,
        'overrides' => [
            AuthGuardOverride::class,
            AuthPasswordOverride::class,
        ],
    ],

    'cookie' => [
        'driver' => CookieOverride::class,
    ],

    'session' => [
        'driver' => SessionOverride::class,
        'database' => false,
    ],
];
