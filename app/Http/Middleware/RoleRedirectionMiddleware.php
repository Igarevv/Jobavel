<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        $currentRole = auth()->user()->role;

        if ($currentRole !== $role) {
            return redirect()->route(
                Role::tryFrom($currentRole)?->roleMainPage()
            );
        }

        return $next($request);
    }

}
