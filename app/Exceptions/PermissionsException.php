<?php

namespace App\Exceptions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class PermissionsException extends \Exception
{
    public function report(): void
    {
        Log::critical('Exception in permission creation system', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ]);
    }

    public function render(): RedirectResponse
    {
        return back()->with('permission-error', 'Something went wrong. Please try again or contact devs');
    }
}
