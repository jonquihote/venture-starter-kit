<?php

namespace Venture\Home\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use TiMacDonald\Middleware\HasParameters;
use Venture\Home\Concerns\InteractsWithModule;
use Venture\Home\Models\Subscription;

class EnsureTeamHasSubscription
{
    use HasParameters;
    use InteractsWithModule;

    public function handle(Request $request, Closure $next, string $slug): Response
    {
        // If the panel is `home`, we're skipping subscription check
        // because `home` module does not require any subscription
        if ($slug === $this->getModuleSlug()) {
            return $next($request);
        }

        $hasSubscription = Subscription::query()
            ->where('team_id', Filament::getTenant()->getKey())
            ->whereHas('application', function (Builder $query) use ($slug): void {
                $query->where('slug', $slug);
            })
            ->exists();

        abort_unless($hasSubscription, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
