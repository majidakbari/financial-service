<?php

namespace App\Exceptions\HttpException\Abstraction;

use RuntimeException;

abstract class HttpException extends RuntimeException
{
    protected string $error;

    public function __construct(int $statusCode, string $message = null)
    {
        $error = get_class_name($this);
        $this->error = $error;

        parent::__construct($message ?? trans("error.$error"), $statusCode, null);
    }

    public function getError(): string
    {
        return $this->error;
    }
}
