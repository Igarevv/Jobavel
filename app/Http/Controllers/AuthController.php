<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function index(Request $request): View
    {
        $request->getSession()->set('previous_url', url()->previous());

        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        if (Auth::attempt($data, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(
                $request->session()->get('previous_url') ?? '/'
            );
        }

        return redirect()->back()->withErrors(
            ['email' => 'Wrong email or password']
        );
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

}
