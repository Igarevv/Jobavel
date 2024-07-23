<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User;

use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Model;

class EmployerAccountRepository implements AccountRepositoryInterface
{

    protected array $mappedFields = [
        'name' => 'company_name',
        'description' => 'company_description',
        'logo' => 'company_logo',
        'type' => 'company_type'
    ];

    public function getById(int|string $userId, ?array $columns = []): Employer
    {
        if (! $columns) {
            $columns = [
                'id', 'employer_id', 'contact_email', 'created_at',
                'company_name', 'company_logo', 'company_description'
            ];
        }

        return is_string($userId) ? Employer::findByUuid($userId, $columns)
            : Employer::findOrFail($userId, $columns);
    }

    public function update(string|int|Model $model, array $data): Employer
    {
        if ($model instanceof Employer) {
            $employer = $model;
        } else {
            $employer = $this->getById($model, ['id', 'contact_email']);
        }

        $transformedData = $this->transformData($data);

        $employer->update($transformedData);

        return $employer;
    }

    protected function transformData(array $data): array
    {
        $transformedData = [];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->mappedFields)) {
                $transformedData[$this->mappedFields[$key]] = $value;
            }
        }

        return $transformedData;
    }

}
