<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$guards
    ): Response {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $prefix = ltrim($request->route()?->getPrefix(), '/') ?: 'home';

                if ($prefix !== 'home') {
                    return to_route(
                        Role::tryFrom($prefix)?->roleMainPage() ?? 'home'
                    );
                }

                return to_route('home');
            }
        }

        return $next($request);
    }

}
