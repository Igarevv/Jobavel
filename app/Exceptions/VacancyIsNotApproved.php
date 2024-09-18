<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

class VacancyIsNotApproved extends VacancyStatusException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Vacancy is not approved, please check it out.', $code, $previous);
    }

}
