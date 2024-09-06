<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RedirectIfEmailVerified
{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user('web')->hasVerifiedEmail()) {
            return redirect()->to('home');
        }

        return $next($request);
    }

}
