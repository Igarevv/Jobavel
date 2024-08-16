<?php

namespace App\Http\Requests\Admin;

use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RoleStoringRequest extends FormRequest
{
    use AfterValidation;

    public function rules(): array
    {
        $availableGuard = array_keys(config('auth.guards'));

        return [
            'role' => ['required', 'string', 'unique:roles,name'],
            'guard' => ['required', 'in:'.implode(',', $availableGuard)]
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $data['role'] = Str::lower($this->role);
        $data['guard'] = Str::lower($this->guard);
    }

}
