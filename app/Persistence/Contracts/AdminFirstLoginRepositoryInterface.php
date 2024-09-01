<?php

namespace App\Persistence\Contracts;

use App\Persistence\Models\Admin;

interface AdminFirstLoginRepositoryInterface
{
    public function getAdminFirstLogin(Admin $admin): ?\stdClass;

    public function deleteAdminFromFirstLogin(int $rowId): void;

    public function allowAdminMakeFirstLogin(int $rowId): void;
}