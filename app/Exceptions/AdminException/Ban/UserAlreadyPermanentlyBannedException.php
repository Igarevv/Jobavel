<?php

declare(strict_types=1);

namespace App\Exceptions\AdminException\Ban;

use Throwable;

class UserAlreadyPermanentlyBannedException extends BanException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            'It is impossible to ban a user who has already been permanently banned.',
            $code,
            $previous
        );
    }

}
