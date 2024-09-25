<?php

namespace App\Persistence\Contracts;

interface GetPublicIdentifierForActionInterface
{
    public function getIdentifier(): string;
}
