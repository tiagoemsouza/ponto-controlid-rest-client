<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Entity;

use DateTime;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class RelatorioArquivoReguladoPorLei extends FlexibleDataTransferObject
{
    public ?string $data;

    /**
     * construct
     *
     * @param array<string, string> $parameters
     */
    public function __construct(array $parameters = [])
    {        
        parent::__construct($parameters);
    }

    /**
     * Undocumented function
     *
     * @return array<RegistroMarcacao>
     */
    public function getRegistrosMarcacoes()
    {
        $result = [];
        $pregPattern = '/^(?<nsr>\d{9})3(?<date>\d{4}-\d{2}-\d{2})T(?<time>\d{2}:\d{2}:\d{2})-03000(?<codigo>\d{11})(?<checksum>[[:xdigit:]]{4})/m';
        
        /**
         * @var array<int, string>
         */
        $matches = [];
        
        if (preg_match_all($pregPattern, $this->data, $matches, PREG_SET_ORDER, 0)) {

            foreach ($matches as $rm) {
                $dateTimeStr = sprintf("%s %s", $rm['date'], $rm['time']);
                $dateTime = new DateTime($dateTimeStr);

                $registroMarcacao = new RegistroMarcacao([
                    'nsr' => $rm['nsr'],
                    'marcacao' => $dateTime,
                    'codigo' => $rm['codigo'],
                ]);

                $result[] = $registroMarcacao;
            }
        }
        return $result;
    }
}
