<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User\Employee;

use App\Contracts\User\UserDtoInterface;
use App\Persistence\Contracts\EmployeeAccountRepositoryInterface;
use App\Persistence\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccountRepository implements EmployeeAccountRepositoryInterface
{

    public function getById(int|string $userId, array $columns = ['*']): Model
    {
        return is_string($userId) ? Employee::findByUuid($userId, $columns)
            : Employee::findOrFail($userId, $columns);
    }

    public function update(Model|int|string $model, UserDtoInterface $user): Model
    {
        if ($model instanceof Employee) {
            $employee = $model;
        } else {
            $employee = $this->getById($model);
        }

        $employee->update([
            'position' => $user->currentPosition,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'preferred_salary' => $user->preferredSalary,
            'about_me' => $user->aboutEmployee,
            'experiences' => $user->experiences,
            'skills' => $user->skills
        ]);

        return $employee;
    }
}
