<?php

namespace Venture\Alpha\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        setPermissionsTeamId(Filament::getTenant()->getKey());

        return $next($request);
    }
}
