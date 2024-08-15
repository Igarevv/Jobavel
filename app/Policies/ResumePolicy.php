<?php

declare(strict_types=1);

namespace App\Policies;

use App\Persistence\Models\Admin;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;

class ResumePolicy
{

    public function before(User $user, string $ability): ?true
    {
        return $user->hasRole(Admin::SUPER_ADMIN) || $user->hasRole(Admin::ADMIN) ? true : null;
    }

    public function view(?User $user, Employee $employee, ?Employer $employer = null): Response
    {
        if (! $user) {
            return Response::denyAsNotFound();
        }

        if (! $employer) {
            if ($user->employee->id !== $employee->id) {
                return Response::denyAsNotFound();
            }
            return Response::allow();
        }

        $employerCanAccess = Vacancy::where('employer_id', $employer->id)
            ->whereHas('employees', function (Builder $builder) use ($employee) {
                $builder->where('employee_vacancy.employee_id', $employee->id);
            })->exists();

        if (! $employerCanAccess) {
            return Response::denyAsNotFound();
        }

        return Response::allow();
    }
}