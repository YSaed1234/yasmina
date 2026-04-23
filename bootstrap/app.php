<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        $middleware->redirectTo(
            guests: function($request) {
                if ($request->is('admin-dashboard-2026/*') || $request->is('admin-dashboard-2026')) {
                    return route('admin.login');
                }
                return '/login';
            },
            users: function() {
                if (auth('admin')->check()) {
                    return '/admin-dashboard-2026';
                }
                return '/';
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
