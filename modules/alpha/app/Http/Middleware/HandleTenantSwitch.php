<?php

namespace Venture\Alpha\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class HandleTenantSwitch
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentTeam = Filament::getTenant();

        $previousTeamId = session('last_team_id');

        $isSwitchingTenant = $previousTeamId && $previousTeamId !== $currentTeam->id;

        Session::put('last_team_id', $currentTeam->id);

        if ($isSwitchingTenant && ! $this->isHomeDashboardRequest($request)) {
            return redirect()->route('filament.home.pages.dashboard', ['tenant' => $currentTeam]);
        }

        return $next($request);
    }

    protected function isHomeDashboardRequest(Request $request): bool
    {
        return $request->route() && $request->route()->getName() === 'filament.home.pages.dashboard';
    }
}
