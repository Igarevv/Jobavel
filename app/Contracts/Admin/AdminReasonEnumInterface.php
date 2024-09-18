<?php

namespace App\Contracts\Admin;

interface AdminReasonEnumInterface
{
    public function toString(): string;

    public function description(): string;
}
