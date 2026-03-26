<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Restrict route access to users whose role is included in $roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect('/login');
        }

        if (! in_array($user->role, $roles, true)) {
            return redirect($user->redirectToDashboard());
        }

        return $next($request);
    }
}
