<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use tiagoemsouza\ControlIdAPI\Adapter\AbstractAdapter;
use tiagoemsouza\ControlIdAPI\Exception\AccessDeniedException;
use tiagoemsouza\ControlIdAPI\Exception\ForbiddenException;
use tiagoemsouza\ControlIdAPI\Exception\InternalServerErrorException;
use tiagoemsouza\ControlIdAPI\Exception\NotFoundException;
use tiagoemsouza\ControlIdAPI\Exception\UnauthorizedException;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

final class AbstractAdapterTest extends ControlIdAPITest
{

    private MockObject $adapter;
    private ReflectionClass $adapterReflection;

    public function setUp(): void
    {
        parent::setUp();

        $this->adapter = $this->getMockForAbstractClass(AbstractAdapter::class);
        $this->adapterReflection = new ReflectionClass(AbstractAdapter::class);
    }

    public function testConstructor(): void
    {
        $clientProperty = $this->adapterReflection->getProperty('client');
        $clientProperty->setAccessible(true);

        /**
         * @var Client
         */
        $client = $clientProperty->getValue($this->adapter);
        $this->assertInstanceOf(Client::class, $client);

        $clientReflection = new ReflectionClass($client);
        $clientConfigReflection = $clientReflection->getProperty('config');
        $clientConfigReflection->setAccessible(true);
        $clientConfig = $clientConfigReflection->getValue($client);
        $this->assertEquals('ip-do-relogio', $clientConfig['base_uri']->getHost());
    }

    public function testRequestSession(): void
    {
        $session = 'x54sd6f1sa6df51x';

        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler();
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $adapterMock = $this->getMockForAbstractClass(
            AbstractAdapter::class,
            [new Client(['handler' => $handlerStack,])]
        );

        $mock->append(new Response(200, []));
        $adapterMock->loadSession($session);

        $requestReflection = $this->adapterReflection->getMethod('request');
        $requestReflection->setAccessible(true);
        $requestReflection->invoke($adapterMock, 'POST', '/', []);

        foreach ($container as $transaction) {
            $requestReflection = new ReflectionClass(Request::class);
            $uriProperty = $requestReflection->getProperty('uri');
            $uriProperty->setAccessible(true);

            $uriObject = $uriProperty->getValue($transaction['request']);
            $uriReflection = new ReflectionClass(Uri::class);
            $queryProperty = $uriReflection->getProperty('query');
            $queryProperty->setAccessible(true);

            $this->assertEquals('session=' . $session, $queryProperty->getValue($uriObject));
        }
    }

    public function testloadSession(): void
    {

        $token = 'x54sd6f1sa6df51x';
        $method = $this->adapterReflection->getMethod('loadSession');
        $method->invoke($this->adapter, $token);

        $property = $this->adapterReflection->getProperty('session');
        $property->setAccessible(true);

        $this->assertEquals($token, $property->getValue($this->adapter));
    }

    public function testHandleErrorsAccessDenied(): void
    {
        $handleErrorsMethod = $this->adapterReflection->getMethod('handleErrors');
        $handleErrorsMethod->setAccessible(true);

        $this->expectException(AccessDeniedException::class);
        $handleErrorsMethod->invoke($this->adapter, new Response(400));
    }

    public function testHandleUnauthorized(): void
    {

        $handleErrorsMethod = $this->adapterReflection->getMethod('handleErrors');
        $handleErrorsMethod->setAccessible(true);

        $this->expectException(UnauthorizedException::class);
        $handleErrorsMethod->invoke($this->adapter, new Response(401));
    }

    public function testHandleErrorsForbidden(): void
    {
        $handleErrorsMethod = $this->adapterReflection->getMethod('handleErrors');
        $handleErrorsMethod->setAccessible(true);

        $this->expectException(ForbiddenException::class);
        $handleErrorsMethod->invoke($this->adapter, new Response(403));
    }

    public function testHandleNotFound(): void
    {
        $handleErrorsMethod = $this->adapterReflection->getMethod('handleErrors');
        $handleErrorsMethod->setAccessible(true);

        $this->expectException(NotFoundException::class);
        $handleErrorsMethod->invoke($this->adapter, new Response(404));
    }

    public function testHandleInternalServerError(): void
    {
        $handleErrorsMethod = $this->adapterReflection->getMethod('handleErrors');
        $handleErrorsMethod->setAccessible(true);

        $this->expectException(InternalServerErrorException::class);
        $handleErrorsMethod->invoke($this->adapter, new Response(500));
    }
}
