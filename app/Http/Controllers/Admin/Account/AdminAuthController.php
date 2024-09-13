<?php

namespace App\Http\Controllers\Admin\Account;

use App\Exceptions\TryToSignInWithTempPasswordSecondTime;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Service\Admin\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function signInIndex(): View
    {
        return view('admin.sign-in');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        try {
            $admin = $this->authService->prepareToLogin($request->toBase());

            Auth::guard('admin')->login($admin);

            $admin->createApiToken();

            $request->session()->regenerate();
        } catch (ModelNotFoundException|TryToSignInWithTempPasswordSecondTime $e) {
            return back()->withErrors(
                ['email' => trans('alerts.login.failed-admin')]
            );
        }

        return redirect()->route('admin.island');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function register(AdminRegisterRequest $request): RedirectResponse
    {
        $this->authService->register($request->getDto());

        return back()->with('registered', 'Admin was successfully registered. We sent email with credentials.');
    }
}
