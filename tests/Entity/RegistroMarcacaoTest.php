<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Entity;

use DateTime;
use tiagoemsouza\ControlIdAPI\Entity\RegistroMarcacao;
use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

class RegistroMarcacaoTest extends ControlIdAPITest
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testProperties(): void
    {
        $data = [
            'nsr' => "003147826",
            'marcacao' => new DateTime("2022-05-26T14:50:00.000Z"),
            'pis' => "073887745615",
        ];
        $registroMarcacao = new RegistroMarcacao($data);
        $this->assertEquals($registroMarcacao->nsr, $data['nsr']);
        $this->assertEquals($registroMarcacao->marcacao, $data['marcacao']);
        $this->assertEquals($registroMarcacao->pis, $data['pis']);
    }
}
