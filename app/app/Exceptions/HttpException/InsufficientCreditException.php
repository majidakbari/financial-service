<?php

namespace App\Exceptions\HttpException;

use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\HTTPException\Abstraction\HttpException;

class InsufficientCreditException extends HttpException
{
    public function __construct()
    {
        parent::__construct(Response::HTTP_BAD_REQUEST);
    }
}
