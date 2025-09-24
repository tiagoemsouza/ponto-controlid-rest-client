<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Exception;

use Psr\Http\Message\ResponseInterface;

class AccessDeniedException extends AbstractHttpException
{
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response, 400);
    }
}
