<?php

namespace App\Http\Middleware;

use App\Persistence\Models\BannedUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenyAccessForBannedUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        $ban = BannedUser::latestBanForUser($request->user('web'), ['banned_until', 'reason_type']);

        if (auth('web')->check() && ($ban?->banned_until && now()->lessThan($ban->banned_until))) {
            auth('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            abort(403, 'Your account has been suspended for '. $ban->banned_until->diffForHumans());
        }

        return $next($request);
    }
}
