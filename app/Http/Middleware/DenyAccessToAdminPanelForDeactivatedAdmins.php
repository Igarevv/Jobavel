<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenyAccessToAdminPanelForDeactivatedAdmins
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check() && auth('admin')->user()?->isDeactivated()) {
            auth('admin')->logout();

            session()->invalidate();

            return redirect()->route('admin.sign-in.show')
                ->with('deactivated', 'Your account has been suspended. Contact to head administrator');
        }

        return $next($request);
    }
}
