<?php

namespace App\Http\Requests\Admin;

use App\Rules\ExistsPermissionRule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class RolePermissionsLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', 'numeric', 'in:'.implode(',', Role::query()->pluck('id')->toArray())],
            'permissions' => ['required', new ExistsPermissionRule()],
        ];
    }
}
