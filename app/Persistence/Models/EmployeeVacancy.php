<?php

declare(strict_types=1);

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeVacancy extends Pivot
{
    protected $table = 'employee_vacancy';
}