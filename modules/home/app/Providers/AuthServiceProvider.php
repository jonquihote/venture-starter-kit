<?php

namespace Venture\Home\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Venture\Home\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Config::set('auth.providers.users.model', User::class);
    }

    public function boot(): void {}
}
