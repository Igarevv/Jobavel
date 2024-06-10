<?php

namespace App\Http\Requests;

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
        if ( ! $this->isMethod('POST')) {
            return [];
        }

        return [
            'firstName' => 'required|max:50|alpha',
            'lastName' => 'required|max:50|alpha',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

}
