<?php

namespace Venture\Home\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Venture\Home\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Config::set('auth.providers.users.model', User::class);

        $this->app->bind(Authenticatable::class, User::class);
    }

    public function boot(): void {}
}
