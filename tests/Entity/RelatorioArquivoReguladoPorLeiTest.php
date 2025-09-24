<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Entity;

use tiagoemsouza\ControlIdAPI\Entity\RegistroMarcacao;
use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;
use tiagoemsouza\ControlIdAPI\Entity\UsuarioLogin;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

class RelatorioArquivoReguladoPorLeiTest extends ControlIdAPITest
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testProperties(): void
    {
        $data = $this->loadFixtures('Entity/RelatorioArquivoReguladoPorLei');
        $relatorioReguladoPorLei = new RelatorioArquivoReguladoPorLei($data);

        $this->assertEquals($relatorioReguladoPorLei->data, base64_decode($data['data']));
        $registrosMarcacoes = $relatorioReguladoPorLei->getRegistrosMarcacoes();
        $this->assertIsArray($registrosMarcacoes);
        $this->assertInstanceOf(RegistroMarcacao::class, $registrosMarcacoes[0]);
    }
}
