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
            'remember' => 'sometimes|boolean',
        ])->validate();

        if (Auth::attempt($data, $data['remember'] ?? false)) {
            $request->session()->regenerate();

            return redirect()->intended(
                $request->session()->get('previous_url') ?? '/'
            );
        }

        return redirect()->back()->withErrors(
            ['email' => 'User with this credentials not found']
        );
    }

    public function logout() {}

}
