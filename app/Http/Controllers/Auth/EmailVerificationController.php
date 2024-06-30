<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomEmailVerificationRequest;
use App\Mail\ConfirmEmail;
use App\Persistence\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{

    public function verifyEmail(CustomEmailVerificationRequest $request
    ): View|RedirectResponse {
        $user = User::query()
            ->where('user_id', $request->route('user_id'))
            ->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return redirect()->to('home');
        }

        $request->fulfill();

        if ($user->is_confirmed) {
            return view('auth.email.success');
        }

        return view('auth.email.failed');
    }

    public function resendEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        Mail::to($user->email)->send(new ConfirmEmail($user));

        return back()->with('email-verify-message', 'Verification link sent!');
    }

}
