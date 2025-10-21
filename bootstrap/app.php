<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Admin routes with /admin prefix
            Route::middleware(['web', 'auth', 'role:admin,staff'])
                ->prefix('admin')
                ->group(base_path('routes/backend.php'));
            
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin/settings')
                ->group(base_path('routes/settings.php'));
            
            // Student/Teacher routes with /member prefix
            Route::middleware(['web', 'auth', 'role:student,teacher'])
                ->prefix('member')
                ->group(base_path('routes/member.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
