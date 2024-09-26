<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\Admin;

use App\DTO\Auth\AdminRegisterDto;
use App\Enums\Admin\AdminAccountStatusEnum;
use App\Persistence\Contracts\AdminAuthRepositoryInterface;
use App\Persistence\Contracts\AdminFirstLoginRepositoryInterface;
use App\Persistence\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class AdminAuthRepository implements AdminAuthRepositoryInterface, AdminFirstLoginRepositoryInterface
{
    public function save(AdminRegisterDto $adminRegisterDto, string $tempPassword): Admin
    {
        return DB::transaction(function () use ($adminRegisterDto, $tempPassword) {
            $admin = Admin::query()->create([
                'email' => $adminRegisterDto->email,
                'first_name' => $adminRegisterDto->firstName,
                'last_name' => $adminRegisterDto->lastName,
                'password' => Hash::make($tempPassword),
                'account_status' => AdminAccountStatusEnum::PENDING_TO_AUTHORIZE->value
            ]);

            $admin->assignRole(Admin::ADMIN);

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
            ->activeAdmins()
            ->first([
                'id',
                'admin_id',
                'email',
                'password',
                'first_name',
                'last_name',
                'account_status'
            ]);
    }

    public function getAdminFirstLogin(Admin $admin): ?stdClass
    {
        return DB::table('admins_login')->where('admin_id', $admin->id)->first();
    }

    public function deleteAdminFromFirstLogin(Admin $admin): void
    {
        DB::table('admins_login')->where('admin_id', $admin->id)->delete();
    }

    public function allowAdminMakeFirstLogin(Admin $admin): void
    {
        DB::table('admins_login')->where('admin_id', $admin->id)->update([
            'first_login_at' => now()
        ]);
    }
}
