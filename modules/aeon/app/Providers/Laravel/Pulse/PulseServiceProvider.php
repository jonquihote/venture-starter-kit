<?php

namespace Venture\Aeon\Providers\Laravel\Pulse;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PulseServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('viewPulse', function ($user = null) {
            if (App::isLocal()) {
                return true;
            }

            return in_array(optional($user)->email, [
                //
            ]);
        });
    }
}
