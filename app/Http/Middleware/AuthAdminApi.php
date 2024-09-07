<?php

namespace App\Http\Middleware;

use App\Persistence\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdminApi
{
    public function handle(Request $request, Closure $next, ?string $onlyFor = null): Response
    {
        $token = $request->bearerToken();

        if (! $token || ! $admin = Admin::where('api_token', $token)->first()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($onlyFor === 'super-admin' && ! $admin->isSuperAdmin()) {
            return response()->json(['error' => 'Forbidden. Allowed only for super-admin'], 403);
        }

        return $next($request);
    }
}
