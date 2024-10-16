<?php

declare(strict_types=1);

namespace App\Exceptions\AppException;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class FormDefaultDataModifiedException extends HttpException
{

    private string $fallbackUrl;

    public function __construct(
        int $statusCode,
        string $fallbackUrl,
        string $message = '',
        ?Throwable $previous = null,
        array $headers = [],
        int $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->fallbackUrl = $fallbackUrl;
    }

    public function getFallbackUrl(): string
    {
        return $this->fallbackUrl;
    }
}
