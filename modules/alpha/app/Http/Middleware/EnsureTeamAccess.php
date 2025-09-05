<?php

namespace Venture\Alpha\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Venture\Alpha\Settings\TenancySettings;

class EnsureTeamAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(TenancySettings::class);

        if ($settings->isSingleTeamMode() && $settings->defaultTeam()) {
            setPermissionsTeamId($settings->defaultTeam()->getKey());
        } else {
            setPermissionsTeamId(Filament::getTenant()->getKey());
        }

        return $next($request);
    }
}
