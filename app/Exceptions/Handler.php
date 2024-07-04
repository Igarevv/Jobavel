<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Invalid Entity ID specified',
            ], 404);
        });
    }

}
