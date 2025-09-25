<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Service;

use DateTime;
use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;

class PontoService extends AbstractService
{

    /**
     * relatorioReguladorPorlei
     *
     * @param object $dataInicio
     * @param int $nsrInicial
     * @param string $tipo
     * @return RelatorioArquivoReguladoPorLei
     */
    public function relatorioAfd671(
        DateTime $dataInicio,
        int $nsrInicial = null,
        int $mode = 671
    ):RelatorioArquivoReguladoPorLei {

        $dataInicio = new DateTime();

        $initial_date = [
            'day' => $dataInicio->format('d'),
            'month' => $dataInicio->format('t'),
            'year' => $dataInicio->format('Y'),
        ];

        $initial_nsr = null;

        $data = $this->adapter->post(
            '/export_afd.fcgi',
            compact('initial_date',  'mode')
        );
        return new RelatorioArquivoReguladoPorLei($data);
    }
}
