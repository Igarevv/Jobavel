<?php

namespace App\Http\Requests\Admin\RolesPermissions;

use App\Rules\ExistsPermissionRule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Permission;

class AdminLinkPermissionToAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin')?->can('manage', Permission::class) !== null;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['uuid_or_email'],
            'permissions' => [new ExistsPermissionRule()]
        ];
    }
}
