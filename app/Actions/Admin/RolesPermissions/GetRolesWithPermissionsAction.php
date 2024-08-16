<?php

namespace App\Actions\Admin\RolesPermissions;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GetRolesWithPermissionsAction
{
    public function handle(): Collection
    {
        return Role::with('permissions')
            ->get()
            ->map(function (Role $role) {
           return (object)[
               'id' => $role->id,
               'name' => $role->name,
               'createdAt' => $role->created_at . 'UTC',
               'updatedAt' => $role->updated_at . ' UTC',
               'permissions' => $role->permissions->map(function (Permission $permission) {
                   return (object) [
                       'id' => $permission->id,
                       'name' => $permission->name,
                       'createdAt' => $permission->created_at . ' UTC',
                       'updatedAt' => $permission->updated_at . ' UTC'
                   ];
               })
           ];
        });
    }
}
