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

        if (auth('web')->check()
            && (($ban?->isBannedPermanently() || $ban?->isBannedTemporarily())
                && now()->lessThan($ban?->banned_until))) {
            auth('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $message = $ban?->banned_until?->diffForHumans();

            abort(403, 'Your account has been suspended '.($message ? 'for '.$message : 'permanently'));
        }

        return $next($request);
    }

}
