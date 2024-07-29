<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetHeaders
{

    private array $headers;

    public function __construct()
    {
        $this->headers = config('headers.add');
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach ($this->headers as $key => $value) {
            $response->headers->set($key, $value, true);
        }

        return $response;
    }
}