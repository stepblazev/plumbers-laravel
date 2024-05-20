<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    public function __construct(
        int $code,
        string|null $message,
        \Throwable|null $previous,
        array $headers
    ) {
        if (!$message) {
            $message = Response::$statusTexts[$code];
        }

        parent::__construct($code, $message, $previous, $headers);
    }
}