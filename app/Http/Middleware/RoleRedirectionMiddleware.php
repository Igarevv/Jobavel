<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RoleRedirectionMiddleware
{

    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        $currentRole = auth()->user()->getRole();

        if ($currentRole !== $role) {
            return redirect()->route(
                Role::tryFrom($currentRole)?->roleMainPage()
            );
        }

        return $next($request);
    }

}
