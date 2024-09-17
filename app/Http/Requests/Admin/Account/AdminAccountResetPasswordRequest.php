<?php

namespace App\Http\Requests\Admin\Account;

use App\Rules\Different;
use Illuminate\Foundation\Http\FormRequest;

class AdminAccountResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password:admin'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'max:255',
                new Different('current_password', 'current and new passwords')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password' => 'Your current password is incorrect.'
        ];
    }
}
