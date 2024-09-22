<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class VacancyUpdateException extends Exception
{

    public function report(): void
    {
        Log::critical('Vacancy not updated', [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'file' => $this->getFile()
        ]);
    }

    public function render(): RedirectResponse
    {
        return back()->withErrors('Something went wrong. Please contact to support', 'edit-errors');
    }
}
