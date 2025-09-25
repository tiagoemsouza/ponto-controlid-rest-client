<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Service;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use tiagoemsouza\ControlIdAPI\Adapter\Adapter;
use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;
use tiagoemsouza\ControlIdAPI\Service\PontoService;
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
            000000000110000000000000000000000000000ControliD                                                                                                                                             066130470450119702025-09-242025-09-252025-09-25T15:11:00-0300003108238299000129                              5753
            00000039132025-09-24T13:32:00-0300004784026940DA3D
            9999999990000000000000004330000000000000000000000000000000000009
            0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
        EOT;
        $this->mock->append(new Response(200, [], $body));

        $dataInicio = new DateTime('2025-09-23');

        $relatorioArquivoReguladoPorLei = $this->pontoService->relatorioAfd671($dataInicio);
        
        $this->assertInstanceOf(RelatorioArquivoReguladoPorLei::class, $relatorioArquivoReguladoPorLei);
    }
}
