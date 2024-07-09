<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnknownUserTryToVerifyCodeException extends \Exception
{
    public function render(): never
    {
        abort(404);
    }
}