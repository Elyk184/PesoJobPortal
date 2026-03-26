<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureUserRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureUserRole::class,
        ]);

        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(function () {
            $user = Auth::user();

            if (! $user) {
                return '/';
            }

            return match ($user->role) {
                'admin' => route('admin.dashboard'),
                'employer' => route('employer.dashboard'),
                default => route('jobseeker.dashboard'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
