<?php

namespace App\Exceptions\HttpException;

use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\HTTPException\Abstraction\HttpException;

class InvalidAcceptHeaderException extends HttpException
{
    /**
     * InvalidAcceptHeaderException constructor.
     */
    public function __construct()
    {
        parent::__construct(Response::HTTP_NOT_ACCEPTABLE);
    }
}
