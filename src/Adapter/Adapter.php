<?php
declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Adapter;

class Adapter extends AbstractAdapter
{
    /**
     * @inheritDoc
     *
     * @param string $path
     * @param array<string, bool|string> $queryParams
     * @return mixed[]
     */
    public function post(string $path, array $queryParams = []): array
    {
        return $this->request('POST', $path, $queryParams);
    }
}
