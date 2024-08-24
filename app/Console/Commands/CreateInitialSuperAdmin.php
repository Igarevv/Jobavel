<?php

namespace App\Console\Commands;

use App\Persistence\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateInitialSuperAdmin extends Command
{
    protected $signature = 'admin:super';

    protected $description = 'Command creates initial super admin';

    public function handle(): void
    {
        if (Admin::query()->where('is_super_admin')->exists()) {
            $this->info('Unable to create super admin. Already exists');
            return;
        }

        $admin = $this->createSuperAdmin();

        $this->info('Success. Your test user:');

        $this->table(['Email', 'Password'], [[$admin->email, 'superadminpassword']]);

        $this->newLine();
    }

    private function createSuperAdmin(): Admin
    {
        return DB::transaction(function () {
            $admin = Admin::query()->create([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'superadminjohn@gmail.com',
                'password' => Hash::make('superadminpassword')
            ]);

            $admin->makeAdminAsSuperAdmin();

            Role::query()->updateOrCreate([
                'name' => Admin::ADMIN,
                'guard_name' => Admin::ADMIN
            ]);

            $admin->assignRole([Admin::ADMIN]);

            return $admin;
        });
    }

}
