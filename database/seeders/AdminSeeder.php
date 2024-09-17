<?php

namespace Database\Seeders;

use App\Persistence\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->truncate();
        Artisan::call('admin:super');

        $admins = Admin::factory(5)->create();

        $admins->each(function (Admin $admin) {
            $admin->assignRole(Admin::ADMIN);
        });
    }
}
