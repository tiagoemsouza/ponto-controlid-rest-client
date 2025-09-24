<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use tiagoemsouza\ControlIdAPI\Adapter\Adapter;
use tiagoemsouza\ControlIdAPI\Entity\UsuarioLogin;
use tiagoemsouza\ControlIdAPI\Service\UsuarioService;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

final class UsuarioServiceTest extends ControlIdAPITest
{

    public MockHandler $mock;
    public UsuarioService $usuarioService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockHandler();
        $handlerStack = HandlerStack::create($this->mock);
        $this->usuarioService = new UsuarioService(new Adapter(new Client(['handler' => $handlerStack])));
    }

    public function testLogin(): void
    {

        $json =  json_encode(['login' => 'sdf', 'password' => 465]);
        $json = $json === false ? null : $json;
        $this->mock->append(new Response(200, [], $json));

        $username = 'xxxx';
        $password = 'abcde';
        $web = true;
        $UsuarioLogin = $this->usuarioService->login($username, $password);

        $this->assertInstanceOf(UsuarioLogin::class, $UsuarioLogin);
    }
}
