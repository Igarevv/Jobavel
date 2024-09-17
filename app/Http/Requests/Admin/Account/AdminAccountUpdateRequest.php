<?php

namespace App\Http\Requests\Admin\Account;

use App\DTO\Admin\AdminAccountDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAccountUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first-name' => ['sometimes', 'string'],
            'last-name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', Rule::unique('admins', 'email')->ignore($this->user('admin')->id)],
        ];
    }

    public function getDto(): AdminAccountDto
    {
        return new AdminAccountDto(
            firstName: $this->get('first-name'),
            lastName: $this->get('last-name'),
            email: $this->get('email')
        );
    }
}
