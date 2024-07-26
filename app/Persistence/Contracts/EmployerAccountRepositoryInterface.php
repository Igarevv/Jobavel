<?php

namespace App\Persistence\Contracts;

interface EmployerAccountRepositoryInterface extends AccountRepositoryInterface
{

    public function takeRandomEmployerLogos(int $count);

}