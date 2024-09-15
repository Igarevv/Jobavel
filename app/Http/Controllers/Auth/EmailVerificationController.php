<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTO\Admin\AdminAccountDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomEmailVerificationRequest;
use App\Persistence\Models\Admin;
use App\Service\Admin\AccountService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{

    public function verifyEmail(CustomEmailVerificationRequest $request): View|RedirectResponse
    {
        if ($request->userIsAlreadyConfirmed()) {
            return redirect()->to('home');
        }

        $user = $request->fulfill();

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

    public function confirmAdminEmailChanging(string $id, string $newEmail, AccountService $accountService): View|RedirectResponse
    {
        $admin = Admin::findByUuid($id, ['id', 'email', 'password']);

        $wasChanged = $accountService->updateEmail($admin, new AdminAccountDto(email: $newEmail));

        return $wasChanged ? view('admin.email-changed') : to_route('home');
    }

}
