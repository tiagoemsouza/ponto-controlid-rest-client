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
        if (!empty($parameters['data'])) {
            $parameters['data'] = base64_decode($parameters['data'], true);
        }
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
        $pregPattern = '/^(\d{9})3(\d{2})(\d{2})(\d{4})(\d{2})(\d{2})(\d{12})(\r\n)/m';
        $pregPattern = '/^(?<nsr>\d{9})3(?<data>\d{4}-\d{2}-\d{2})T(?<hora>\d{2}:\d{2}:\d{2})-03000(?<cpf>\d{11})(?<checksum>[[:xdigit:]]{4})/m';
        
        /**
         * @var array<int, string>
         */
        $matches = [];
        
        if (preg_match_all($pregPattern, $this->data, $matches, PREG_SET_ORDER, 0)) {
            foreach ($matches as $rm) {
                $dateTimeStr = sprintf("%02d-%02d-%04d %02d:%02d:%02d", $rm[2], $rm[3], $rm[4], $rm[5], $rm[6], '00');
                $dateTime = new DateTime($dateTimeStr);

                $registroMarcacao = new RegistroMarcacao([
                    'nsr' => $rm[1],
                    'marcacao' => $dateTime,
                    'pis' => $rm[7],
                ]);

                $result[] = $registroMarcacao;
            }
        }
        return $result;
    }
}
