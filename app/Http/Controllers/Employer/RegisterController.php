<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployerRegisterRequest;

class RegisterController extends Controller
{

    // TODO добавить проверку на уникальность названии компании + почты
    public function __invoke(EmployerRegisterRequest $request)
    {
        if ($request->isMethod('GET')) {
            return view('employer.register');
        }
    }

}
