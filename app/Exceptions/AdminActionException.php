<?php

declare(strict_types=1);

namespace App\Exceptions;

use DomainException;

class AdminActionException extends DomainException
{

    public static function mustImplementInterfaceToGetPublicId(): static
    {
        return new static (
            'Action model must implements GetPublicIdentifierForActionInterface, that will allow to view public id of actionable modal'
        );
    }

}
