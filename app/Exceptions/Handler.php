<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (InvalidRoleException $e) {
            Log::error($e->getMessage());
            return back()->with('error',
                'Bad developer made some errors: invalid role');
        });
    }

}
