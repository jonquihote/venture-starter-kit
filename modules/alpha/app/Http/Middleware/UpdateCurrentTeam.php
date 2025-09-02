<?php

namespace Venture\Alpha\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateCurrentTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only update if user is authenticated and a tenant is set
        if (Auth::check() && Filament::getTenant()) {
            $currentUser = Auth::user();
            $currentTenant = Filament::getTenant();

            // Update current_team_id if it's different from the current tenant
            if ($currentUser->current_team_id !== $currentTenant->id) {
                $currentUser->update(['current_team_id' => $currentTenant->id]);
            }
        }

        return $next($request);
    }
}
