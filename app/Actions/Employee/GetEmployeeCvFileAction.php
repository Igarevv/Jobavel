<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Persistence\Models\Employee;
use App\Persistence\Repositories\File\CV\S3CvStorage;

class GetEmployeeCvFileAction
{
    public function __construct(
        private S3CvStorage $cvStorage
    ) {
    }

    public function handle(Employee $employee): false|string
    {
        return $this->cvStorage->get($employee->resume_file);
    }
}