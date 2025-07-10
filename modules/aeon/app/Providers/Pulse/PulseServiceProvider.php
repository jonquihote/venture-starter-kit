<?php

namespace Venture\Aeon\Providers\Pulse;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PulseServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('viewPulse', function ($user = null) {
            return in_array(optional($user)->email, [
                //
            ]);
        });
    }
}
