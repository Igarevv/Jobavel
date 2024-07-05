<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Model;

class EmployerAccountRepository implements AccountRepositoryInterface
{

    public function getById(int|string $id): Model
    {
        return Employer::query()->where('employer_id', $id)->first([
            'employer_id', 'contact_email', 'created_at',
            'company_name', 'company_logo', 'company_description',
        ]);
    }

}
