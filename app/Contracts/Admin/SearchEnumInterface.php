<?php

namespace App\Contracts\Admin;

interface SearchEnumInterface
{
    public function toDbField(): string;

    public function toString(): string;
}