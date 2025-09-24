<?php
declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests\Entity;

use tiagoemsouza\ControlIdAPI\Entity\UsuarioLogin;
use tiagoemsouza\ControlIdAPI\Tests\ControlIdAPITest;

class UsuarioLoginTest extends ControlIdAPITest
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testProperties(): void
    {
        $data = $this->loadFixtures('Entity/UsuarioLogin');
        $UsuarioLogin = new UsuarioLogin($data);
        $this->assertEquals($UsuarioLogin->session, $data['session']);
    }
}
