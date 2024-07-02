<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomEmailVerificationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{

    public function verifyEmail(CustomEmailVerificationRequest $request
    ): View|RedirectResponse {
        $user = $request->fulfill();

        if ($user?->hasVerifiedEmail()) {
            return redirect()->to('home');
        }

        if ($user?->is_confirmed) {
            return view('auth.email.success');
        }

        return view('auth.email.failed');
    }

    public function resendEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->to('home');
        }

        event(new Registered($user));

        return back()->with('email-verify-message', 'Verification link sent!');
    }

}
