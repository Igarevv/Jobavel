<?php

namespace App\Persistence\Contracts;

use App\Persistence\Models\Admin;
use stdClass;

interface AdminFirstLoginRepositoryInterface
{
    public function getAdminFirstLogin(Admin $admin): ?stdClass;

    public function deleteAdminFromFirstLogin(Admin $admin): void;

    public function allowAdminMakeFirstLogin(Admin $admin): void;
}
