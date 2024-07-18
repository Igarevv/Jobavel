<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AccountService
{
    protected AccountRepositoryInterface $accountRepository;

    public function __construct(
        protected AccountRepositoryFactory $factory
    ) {
        $this->accountRepository = $this->factory->make();
    }

    public function getUseById(string|int $id): Model
    {
        $model = $this->getRepository()->getById($id);

        if (! $model) {
            throw new ModelNotFoundException("Model with public id: $id not found");
        }

        return $model;
    }

    protected function getRepository(): AccountRepositoryInterface
    {
        return $this->accountRepository;
    }
}
