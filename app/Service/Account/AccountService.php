<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AccountService
{

    protected AccountRepositoryInterface $repository;

    public function __construct(
        protected AccountRepositoryFactory $factory
    ) {
        $this->repository = $this->factory->make();
    }

    public function getUseById(string|int $id): Model
    {
        return $this->repository->getById($id);
    }

}
