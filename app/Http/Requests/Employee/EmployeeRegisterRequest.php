<?php

namespace App\Http\Requests\Employee;

use App\DTO\Auth\RegisterEmployeeDto;
use App\Persistence\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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

    public function getDto(): RegisterEmployeeDto
    {
        $validated = $this->validated();

        return new RegisterEmployeeDto(
            firstName: $validated['firstName'],
            lastName: $validated['lastName'],
            email: $validated['email'],
            password: Hash::make($validated['password'], ['rounds' => 12]),
            role: User::EMPLOYEE
        );
    }
}
