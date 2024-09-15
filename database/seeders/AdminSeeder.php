<?php

namespace Database\Seeders;

use App\Persistence\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::flushEventListeners();
        Admin::query()->truncate();

        $admins = Admin::factory(5)->create();

        $admins->each(function (Admin $admin) {
            $admin->assignRole(Admin::ADMIN);
        });
    }
}
