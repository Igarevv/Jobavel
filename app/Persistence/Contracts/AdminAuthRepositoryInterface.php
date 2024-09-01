<?php

namespace App\Persistence\Contracts;

use App\DTO\Auth\AdminRegisterDto;
use App\Persistence\Models\Admin;

interface AdminAuthRepositoryInterface
{
    public function save(AdminRegisterDto $adminRegisterDto, string $tempPassword): Admin;

    public function getByEmail(string $email): ?Admin;
}