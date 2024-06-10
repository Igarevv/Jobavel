<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRegisterRequest;

class RegisterController extends Controller
{

    // TODO добавить проверку на уникальность почты
    public function __invoke(EmployeeRegisterRequest $request)
    {
        if ($request->isMethod('GET')) {
            return view('employee.register');
        }
    }

}
