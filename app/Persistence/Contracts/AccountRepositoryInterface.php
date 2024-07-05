<?php

namespace App\Persistence\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AccountRepositoryInterface
{

    public function getById(string|int $id): Model;

}
