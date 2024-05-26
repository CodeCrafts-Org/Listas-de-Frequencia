<?php

namespace CodeCrafts\ListasDeFrequencia\Tests;

require __DIR__ . '/../vendor/autoload.php';

use CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers\ApplicationContainer;
use Exception;
use Throwable;

try {
    $applicationContainer = new ApplicationContainer;
    $listasDeFrequenciaService = $applicationContainer->makeListasDeFrequenciaService();
    $lista = $listasDeFrequenciaService->createLista([
        'titulo' => 'Aaa 1',
        'listador_de_frequencia_id' => '1',
        'listador_de_frequencia_type' => 'Aaa\Aaa',
        'data_de_lancamento' => date('Y-m-d'), 
    ]);
    $frequencia = $listasDeFrequenciaService->createFrequenciaForLista($lista->getId(), [
        'is_presente' => true,
        'titulo' => 'Aaa 2',
        'frequenciavel_id' => '2',
        'frequenciavel_type' => 'Aaa\Aaa',
    ]);
    $result = $listasDeFrequenciaService->setPresencaFromFrequencia($frequencia->getId(), false);
    if ($result === true) {
        echo 'Teste de atualização bem-sucedido' . PHP_EOL;
    } else {
        throw new Exception('Expected result to be true');
    }
} catch (Throwable $throwable) {
    echo $throwable->getMessage() . PHP_EOL;
}
