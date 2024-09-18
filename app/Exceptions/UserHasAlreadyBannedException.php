<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

class UserHasAlreadyBannedException extends BanException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('It is impossible to ban user who has already have ban.', $code, $previous);
    }

}
