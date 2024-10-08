<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        HttpException::class,
    ];

    public function register(): void
    {
        $this->reportable(function (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Invalid Entity ID specified',
            ], 404);
        });
    }

    public function render(
        $request,
        Throwable $e
    ): Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response {
        if ($this->isHttpException($e) && $e->getStatusCode() === 400) {
            return response()->view('errors.400', [
                'message' => $e->getMessage(),
                'url' => $e->getFallbackUrl()
            ], 400);
        }

        if ($e instanceof AuthorizationException) {
            abort(404);
        }

        if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ]);
        }

        return parent::render($request, $e);
    }
}
