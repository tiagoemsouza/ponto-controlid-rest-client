<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Entity;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class UsuarioLogin extends FlexibleDataTransferObject
{
    public ?string $session;
}
