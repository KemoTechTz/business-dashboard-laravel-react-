<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\TenantScopeMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(api: __DIR__.'/../routes/api.php')
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => TenantScopeMiddleware::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->create();
