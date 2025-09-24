<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Service;

use tiagoemsouza\ControlIdAPI\Entity\UsuarioLogin;

class UsuarioService extends AbstractService
{
    
    /**
     * Undocumented function
     *
     * @param string $username
     * @param string $password
     * @param boolean $web
     * @return UsuarioLogin
     */
    public function login(string $username, string $password, bool $web = true): UsuarioLogin
    {
        $data = $this->adapter->post('/login.fcgi', compact('login', 'password'));
        $UsuarioLogin = new UsuarioLogin($data);
        return $UsuarioLogin;
    }
}
