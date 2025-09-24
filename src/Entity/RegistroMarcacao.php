<?php
declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Entity;

use DateTime;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class RegistroMarcacao extends FlexibleDataTransferObject
{
    public string $nsr;
    public DateTime $marcacao;
    public string $pis;
}
