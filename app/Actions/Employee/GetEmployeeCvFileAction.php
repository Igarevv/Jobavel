<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Contracts\Storage\CvStorageInterface;
use App\Persistence\Models\Employee;

class GetEmployeeCvFileAction
{
    public function __construct(
        private CvStorageInterface $cvStorage
    ) {
    }

    public function handle(Employee $employee): false|string
    {
        return $this->cvStorage->get($employee->resume_file);
    }
}
