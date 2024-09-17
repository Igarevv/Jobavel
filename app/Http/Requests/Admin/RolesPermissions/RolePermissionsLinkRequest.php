<?php

namespace App\Http\Requests\Admin\RolesPermissions;

use App\Rules\ExistsPermissionRule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin')?->can('manage', Permission::class) !== null;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'numeric', 'in:'.implode(',', Role::query()->pluck('id')->toArray())],
            'permissions' => ['required', new ExistsPermissionRule()],
        ];
    }
}
