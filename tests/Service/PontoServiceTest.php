<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use tiagoemsouza\ControlIdAPI\Adapter\Adapter;
use tiagoemsouza\ControlIdAPI\Entity\RegistroMarcacao;
use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;
use tiagoemsouza\ControlIdAPI\Exception\ForbiddenException;
use tiagoemsouza\ControlIdAPI\Service\PontoService;
use tiagoemsouza\ControlIdAPI\Service\UsuarioService;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

final class PontoServiceTest extends ControlIdAPITest
{

    public MockHandler $mock;
    public PontoService $pontoService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mock = new MockHandler();
        $handlerStack = HandlerStack::create($this->mock);
        $this->pontoService = new PontoService(new Adapter(new Client(['handler' => $handlerStack])));
    }

    public function test(): void
    {
        $body = <<<EOT
            data:text/plain;base64,MDAwMDAwMDAwMTEwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMCAgIC
            AgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA
            gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg
            ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDBCUjUxMjAyMDAwMTIwMi03MjYwNTIwMjIyN
            jA1MjAyMjA5MDYyMDIyMTQ1MAowMDMxNDc4MjYzMjYwNTIwMjIxNDUwMDczODg3NzQ1NjE1CjAwMz
            E1MTMxOTMyNjA1MjAyMjE3NTYwNzM4ODc3NDU2MTUKOTk5OTk5OTk5MDAwMDAwMDAwMDAwMDAwMDA
            yMDAwMDAwMDAwMDAwMDAwMDAwOQo=
        EOT;
        $this->mock->append(new Response(200, [], $body));

        $dataFim = "2022-05-26T23:59:59.999Z";
        $dataInicio = "2022-05-26T07:00:00.000Z";
        $somenteAtivos = false;
        $tipo = "AFD";

        $relatorioArquivoReguladoPorLei = $this->pontoService->relatorioReguladorPorlei(
            $dataInicio,
            $dataFim,
            $somenteAtivos,
            $tipo
        );
        
        $this->assertInstanceOf(RelatorioArquivoReguladoPorLei::class, $relatorioArquivoReguladoPorLei);
    }
}
