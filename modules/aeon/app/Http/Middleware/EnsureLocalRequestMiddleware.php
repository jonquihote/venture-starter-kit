<?php

namespace Venture\Aeon\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureLocalRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedIps = ['127.0.0.1', '::1', $request->server('SERVER_ADDR')];

        if (! in_array($request->ip(), $allowedIps)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
