<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Service;

use GuzzleHttp\Client;
use Reflection;
use ReflectionClass;
use tiagoemsouza\ControlIdAPI\Adapter\Adapter;
use tiagoemsouza\ControlIdAPI\Service\AbstractService;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

final class AbstractServiceTest extends ControlIdAPITest
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testConstructor(): void
    {
        $service = $this->getMockForAbstractClass(AbstractService::class, [new Adapter()]);

        $serviceReflection = new ReflectionClass(AbstractService::class);
        $adapterReflection = $serviceReflection->getProperty('adapter');
        $adapterReflection->setAccessible(true);

        $this->assertInstanceOf(Adapter::class, $adapterReflection->getValue($service));
    }
}
