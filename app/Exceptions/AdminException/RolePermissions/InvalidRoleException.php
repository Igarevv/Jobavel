<?php

namespace App\Exceptions\AdminException\RolePermissions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class InvalidRoleException extends Exception
{

    public function report(): void
    {
        Log::error($this->getMessage());
    }

    public function render(): RedirectResponse
    {
        return back()->with(
            'error',
            'Bug error: invalid role. Please contact to support team with this message'
        );
    }

}
