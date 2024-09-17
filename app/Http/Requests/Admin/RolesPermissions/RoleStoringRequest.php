<?php

namespace App\Http\Requests\Admin\RolesPermissions;

use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RoleStoringRequest extends FormRequest
{
    use AfterValidation;

    public function authorize(): bool
    {
        return $this->user('admin')?->can('manage', Permission::class) !== null;
    }

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
