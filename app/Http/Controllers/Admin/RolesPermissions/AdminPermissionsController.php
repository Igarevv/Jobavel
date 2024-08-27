<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Exceptions\PermissionsException;
use App\Http\Requests\Admin\PermissionStoringRequest;
use App\Http\Requests\Admin\RolePermissionsLinkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminPermissionsController
{
    public function storePermission(PermissionStoringRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Permission::create(['name' => $data['permission'], 'guard' => $data['guard']]);
        } catch (\Throwable $e) {
            throw new PermissionsException($e->getMessage(), $e->getCode());
        }

        return back()->with('permission-created', trans('alerts.permissions.created'));
    }

    public function linkPermissionsToRole(RolePermissionsLinkRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $role = Role::query()->findOrFail($data['role']);

        $role->syncPermissions($data['permissions']);

        return back()->with('permissions-linked', trans('alerts.permissions.linked'));
    }

    public function permissionsByRole(Role $role): JsonResponse
    {
        return response()->json([
            'role' => $role->name,
            'permissions' => $role->permissions()->get(['id']),
        ]);
    }
    
    public function delete(string $permission): RedirectResponse
    {
        $rowsDeleted = Permission::query()->where('name', $permission)->delete();

        return $rowsDeleted >= 1
            ? back()->with('permission-revoked', 'Permission was successfully revoked.')
            : back()->with('permission-not-found', 'Permission not found. Try again');
    }
}