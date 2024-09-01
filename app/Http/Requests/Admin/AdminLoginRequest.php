<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    public function toBase(): object
    {
        return (object)[
            'email' => $this->get('email'),
            'password' => $this->get('password')
        ];
    }
}
