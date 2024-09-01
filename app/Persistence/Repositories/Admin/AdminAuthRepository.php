<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\Admin;

use App\DTO\Auth\AdminRegisterDto;
use App\Persistence\Contracts\AdminAuthRepositoryInterface;
use App\Persistence\Contracts\AdminFirstLoginRepositoryInterface;
use App\Persistence\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthRepository implements AdminAuthRepositoryInterface, AdminFirstLoginRepositoryInterface
{
    public function save(AdminRegisterDto $adminRegisterDto, string $tempPassword): Admin
    {
        return DB::transaction(function () use ($adminRegisterDto, $tempPassword) {
            $admin = Admin::query()->create([
                'email' => $adminRegisterDto->email,
                'first_name' => $adminRegisterDto->firstName,
                'last_name' => $adminRegisterDto->lastName,
                'password' => Hash::make($tempPassword, ['rounds' => 12])
            ]);

            DB::table('admins_login')->insert([
                'admin_id' => $admin->admin_id,
            ]);

            return $admin;
        });
    }

    public function getByEmail(string $email): ?Admin
    {
        return Admin::query()
            ->where('email', $email)
            ->where('is_active', true)
            ->first(['id', 'admin_id', 'email', 'password']);
    }

    public function getAdminFirstLogin(Admin $admin): ?\stdClass
    {
        return DB::table('admins_login')->where('admin_id', $admin->admin_id)->first();
    }

    public function deleteAdminFromFirstLogin(int $rowId): void
    {
        DB::table('admins_login')->where('id', $rowId)->delete();
    }

    public function allowAdminMakeFirstLogin(int $rowId): void
    {
        DB::table('admins_login')->where('id', $rowId)->update([
            'first_login_at' => now()
        ]);
    }
}