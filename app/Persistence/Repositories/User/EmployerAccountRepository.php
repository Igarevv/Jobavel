<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User;

use App\Persistence\Contracts\EmployerAccountRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployerAccountRepository implements EmployerAccountRepositoryInterface
{

    protected array $mappedFields = [
        'name' => 'company_name',
        'description' => 'company_description',
        'logo' => 'company_logo',
        'type' => 'company_type'
    ];

    public function getById(int|string $userId, ?array $columns = ['*']): Employer
    {
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

    public function takeRandomEmployerLogos(int $count): Collection
    {
        return Employer::query()->has('vacancy')
            ->inRandomOrder()->take($count)->get(['id', 'company_logo']);
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
