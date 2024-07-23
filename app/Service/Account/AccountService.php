<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AccountService
{
    protected AccountRepositoryInterface $accountRepository;

    public function __construct(
        protected AccountRepositoryFactory $factory
    ) {
        $this->accountRepository = $this->factory->make();
    }

    public function getEmpUserById(string|int $id): Model
    {
        return $this->accountRepository->getById($id);
    }

    protected function getRepository(): AccountRepositoryInterface
    {
        return $this->accountRepository;
    }
}
