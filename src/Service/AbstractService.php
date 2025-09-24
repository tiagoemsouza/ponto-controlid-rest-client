<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Service;

use tiagoemsouza\ControlIdAPI\Adapter\AdapterInterface;

abstract class AbstractService
{

    protected AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}
