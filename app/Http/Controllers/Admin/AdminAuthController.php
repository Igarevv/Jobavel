<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function signInIndex()
    {
        return view('admin.sign-in');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();

        if (Auth::guard('admin')->attempt($data)) {
            $request->session()->regenerate();

            return redirect()->route('admin.island');
        }

        return back()->withErrors(
            ['email' => trans('alerts.login.failed')]
        );
    }
}
