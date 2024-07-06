<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountService
{

    public function __construct(
        protected AccountRepositoryFactory $factory
    ) {
    }

    public function getUseById(string|int $id): Model
    {
        $model = $this->getInitializedRepository()->getById($id);

        if (! $model) {
            throw new ModelNotFoundException("Model with public id: $id not found");
        }

        return $model;
    }

    protected function getInitializedRepository(): AccountRepositoryInterface
    {
        return $this->factory->make();
    }
}
