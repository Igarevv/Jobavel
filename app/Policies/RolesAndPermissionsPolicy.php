<?php

namespace App\Policies;

use App\Persistence\Models\Admin;

class RolesAndPermissionsPolicy
{
    public function before(Admin $admin): ?true
    {
        return $admin->isSuperAdmin() ? true : null;
    }

    public function view(Admin $admin): true
    {
        if (! $admin->hasPermissionTo('permissions-view')) {
            abort(403, 'This action only allowed for super-admins or permitted admins');
        }

        return true;
    }

    public function manage(Admin $admin): true
    {
        if (! $admin->hasPermissionTo('permissions-manage')) {
            abort(403, 'This action only allowed for super-admins or permitted admins');
        }

        return true;
    }
}
