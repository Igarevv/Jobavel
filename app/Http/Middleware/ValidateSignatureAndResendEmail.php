<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ValidateSignatureAndResendEmail
{

    public function handle(
        Request $request,
        Closure $next,
        string $relative = null
    ): Response {
        if ( ! URL::hasCorrectSignature($request, $relative !== 'relative')) {
            throw new InvalidSignatureException();
        }

        if (URL::signatureHasNotExpired($request)) {
            return $next($request);
        }

        return redirect()->route('resend-email-confirmation');
    }

}
