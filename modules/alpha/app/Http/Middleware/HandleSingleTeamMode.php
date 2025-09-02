<?php

namespace Venture\Alpha\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Venture\Alpha\Settings\TenancySettings;

class HandleSingleTeamMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $settings = App::make(TenancySettings::class);

            if ($settings->isSingleTeamMode()) {
                Filament::setTenant($settings->defaultTeam());
            }
        }

        return $next($request);
    }
}
