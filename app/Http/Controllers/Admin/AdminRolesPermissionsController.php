<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\RolesPermissions\GetRolesWithPermissionsAction;
use App\Exceptions\PermissionsException;
use App\Exceptions\RoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionStoringRequest;
use App\Http\Requests\Admin\RolePermissionsLinkRequest;
use App\Http\Requests\Admin\RoleStoringRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolesPermissionsController extends Controller
{
    public function index(GetRolesWithPermissionsAction $rolesPermissions): View
    {
        return view('admin.roles-permissions', [
            'roles' => $rolesPermissions->handle(),
            'allPermissions' => Permission::query()->toBase()->get(['id', 'name']),
            'guards' => array_keys(config('auth.guards')),
        ]);
    }

    public function storeRole(RoleStoringRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Role::create(['name' => $data['role'], 'guard_name' => $data['guard']]);
        } catch (\Throwable $e) {
            throw new RoleException($e);
        }

        return back()->with('role-created', trans('alerts.roles.created'));
    }

    public function storePermission(PermissionStoringRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Permission::create(['name' => $data['permission'], 'guard' => $data['guard']]);
        } catch (\Throwable $e) {
            throw new PermissionsException($e);
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
}
