<?php

namespace App\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

class NoContentResponse extends Response
{
    public function __construct()
    {
        parent::__construct(status: Response::HTTP_NO_CONTENT);
    }
}