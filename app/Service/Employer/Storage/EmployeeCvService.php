<?php

declare(strict_types=1);

namespace App\Service\Employer\Storage;

use App\Contracts\Storage\CvStorageInterface;
use App\Persistence\Models\Employee;
use Illuminate\Http\UploadedFile;

class EmployeeCvService
{
    public function __construct(
        protected CvStorageInterface $cvStorage
    ) {
    }

    public function upload(UploadedFile $file, Employee $employee): bool
    {
        if ($employee->resume_file !== null) {
            $this->cvStorage->delete($employee->resume_file);
        }

        if (! $this->cvStorage->upload($file)) {
            return false;
        }

        $employee->update(['resume_file' => $file->hashName()]);

        return true;
    }

    public function delete(Employee $employee): bool
    {
        if ($this->cvStorage->delete($employee->resume_file)) {
            $employee->clearCvPath();

            return true;
        }
        return false;
    }

}