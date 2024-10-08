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

    public function handle(Employee $employee): ?string
    {
        if (! $this->cvStorage->isExists($employee->resume_file)) {
            return null;
        }
        
        return $this->cvStorage->get($employee->resume_file);
    }
}
