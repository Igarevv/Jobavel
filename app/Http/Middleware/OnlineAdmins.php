<?php

namespace App\Http\Middleware;

use App\Service\Cache\Cache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlineAdmins
{

    public function __construct(
        private Cache $cache
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check()) {
            $cacheKey = $this->cache->getCacheKey('online-admins', auth('admin')->user()?->getAdminId());

            $this->cache->repository()->put($cacheKey, true, now()->addMinutes(10));
        }

        return $next($request);
    }

}
