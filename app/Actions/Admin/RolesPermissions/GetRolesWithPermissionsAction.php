<?php

namespace App\Actions\Admin\RolesPermissions;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GetRolesWithPermissionsAction
{
    public function handle(): array
    {
        return [$this->getRoles(), $this->getPermissions()];
    }

    private function getRoles(): Collection
    {
        return Role::query()
            ->get()
            ->map(function (Role $role) {
                $timezone = $role->created_at->getTimezone();

                return (object)[
                    'id' => $role->id,
                    'name' => $role->name,
                    'createdAt' => $role->created_at->format('Y-m-d H:i').' '.$timezone,
                    'updatedAt' => $role->updated_at->format('Y-m-d H:i').' '.$timezone,
                ];
            });
    }

    private function getPermissions(): Collection
    {
        return Permission::query()
            ->get()
            ->mapToGroups(function (Permission $permission) {
                $timezone = $permission->created_at->getTimezone();

                $permissionInfo = (object)[
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard' => $permission->guard_name,
                    'createdAt' => $permission->created_at->format('Y-m-d H:i').' '.$timezone,
                    'updatedAt' => $permission->updated_at->format('Y-m-d H:i').' '.$timezone
                ];

                return [$permission->guard_name => $permissionInfo];
            });
    }
}
