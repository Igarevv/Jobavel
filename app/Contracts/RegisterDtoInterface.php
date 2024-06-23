<?php

namespace App\Contracts;

interface RegisterDtoInterface
{

    public function toDatabaseContext(): array;

}
