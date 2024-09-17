<?php

namespace App\Http\Requests\Admin\RolesPermissions;

use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionStoringRequest extends FormRequest
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
            'permission' => ['required', 'string', 'unique:permissions,name'],
            'guard' => ['required', 'in:'.implode(',', $availableGuard)],
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        $data['permission'] = Str::lower(
            preg_replace('/\s+/', '-', $this->permission)
        );

        $data['guard'] = Str::lower($this->guard);
    }
}
