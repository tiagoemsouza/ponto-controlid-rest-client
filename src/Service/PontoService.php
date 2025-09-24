<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Service;

use tiagoemsouza\ControlIdAPI\Entity\RelatorioArquivoReguladoPorLei;

class PontoService extends AbstractService
{

    /**
     * relatorioReguladorPorlei
     *
     * @param string $dataInicio
     * @param string $dataFim
     * @param boolean $somenteAtivos
     * @param string $tipo
     * @return RelatorioArquivoReguladoPorLei
     */
    public function relatorioAfd671(
        string $dataInicio,
        bool $somenteAtivos = true,
        string $tipo = 'AFD'
    ):RelatorioArquivoReguladoPorLei {
        $data = $this->adapter->post(
            '/ponto/relatorioReguladoPorLei',
            compact('dataInicio', 'dataFim', 'somenteAtivos', 'tipo')
        );
        return new RelatorioArquivoReguladoPorLei($data);
    }
}
