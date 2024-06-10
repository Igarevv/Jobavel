<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployerRegisterRequest extends FormRequest
{

    protected $redirect = '/employer/register';

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
            'company' => 'required|max:256',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

}
