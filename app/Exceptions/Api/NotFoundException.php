<?php

namespace App\Exceptions\Api;

use App\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends BaseException
{
    public function __construct(
        string $message = null,
        int $code = Response::HTTP_NOT_FOUND,
        \Throwable $previous = null,
        array $headers = []
    ) {
        parent::__construct($code, $message, $previous, $headers);
    }
}