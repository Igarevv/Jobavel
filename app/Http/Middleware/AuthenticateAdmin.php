<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next, ?string $onlyFor = null): Response
    {
        if (! auth('admin')->check()) {
            abort(404);
        }

        if ($onlyFor === 'super-admin' && ! $request->user('admin')?->isSuperAdmin()) {
            abort(403, 'Viewing this page allowed only for super admin');
        }

        return $next($request);
    }
}
