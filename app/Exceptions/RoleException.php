<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class RoleException extends Exception
{
    public function report(): void
    {
        Log::critical('Exception in role creation system', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ]);
    }

    public function render(): RedirectResponse
    {
        return back()->with('role-error', 'Something went wrong. Please try again or contact devs');
    }
}
