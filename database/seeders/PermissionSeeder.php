<?php

namespace Database\Seeders;

use App\Persistence\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    private array $permissions = [
        'vacancy-create',
        'vacancy-edit',
        'vacancy-apply',
        'vacancy-delete',
        'vacancy-publish',
        'vacancy-view',
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $employerRole = Role::create(['name' => User::EMPLOYER]);
        $employeeRole = Role::create(['name' => User::EMPLOYEE]);

        $employerRole->givePermissionTo(
            'vacancy-create',
            'vacancy-edit',
            'vacancy-delete',
            'vacancy-publish',
            'vacancy-view',
        );

        $employeeRole->givePermissionTo('vacancy-apply');
    }
}
