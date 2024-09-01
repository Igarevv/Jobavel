<?php

namespace App\Http\Requests\Admin;

use App\DTO\Auth\AdminRegisterDto;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:admins,email'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
        ];
    }

    public function getDto(): AdminRegisterDto
    {
        return new AdminRegisterDto(
            email: $this->get('email'),
            firstName: $this->get('first_name'),
            lastName: $this->get('last_name'),
        );
    }
}
