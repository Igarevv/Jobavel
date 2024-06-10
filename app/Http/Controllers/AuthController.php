<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function index(Request $request): View
    {
        $request->getSession()->set('previous_url', url()->previous());

        return view('login');
    }

    public function login(Request $request) {}

    public function logout() {}

}
