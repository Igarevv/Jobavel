<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRegisterRequest extends FormRequest
{

    protected $redirect = '/employee/register';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (! $this->isMethod('POST')) {
            return [];
        }

        return [
            'firstName' => 'required|max:50|alpha',
            'lastName' => 'required|max:50|alpha',
            'email' => 'required|email|unique:users,email|unique:employees,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

}
