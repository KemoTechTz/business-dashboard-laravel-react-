<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantScopeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->business_id) {
            abort(403, 'Business context missing.');
        }

        app()->instance('tenant_id', $request->user()->business_id);

        return $next($request);
    }
}
