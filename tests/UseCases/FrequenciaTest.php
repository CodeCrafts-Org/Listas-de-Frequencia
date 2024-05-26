<?php

namespace CodeCrafts\ListasDeFrequencia\Tests\UseCases;

use CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers\ApplicationContainer;
use Exception;
use Throwable;

class FrequenciaTest
{
    public function testFrequenciaCreation(): void
    {
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
                'titulo' => 'Bbb 1',
                'frequenciavel_id' => '1',
                'frequenciavel_type' => 'Bbb\Bbb',
            ]);
            if ($frequencia !== null) {
                echo 'Teste de criação bem-sucedido' . PHP_EOL;
            } else {
                throw new Exception('Foi esperado que o retorno de createFrequenciaForLista fosse diferente de null');
            }
        } catch (Throwable $throwable) {
            echo $throwable->getMessage() . PHP_EOL;
        }
    }

    public function testPresencaUpdateOnFrequencia(): void
    {
        try {
            $applicationContainer = new ApplicationContainer;
            $listasDeFrequenciaService = $applicationContainer->makeListasDeFrequenciaService();
            $lista = $listasDeFrequenciaService->createLista([
                'titulo' => 'Aaa 2',
                'listador_de_frequencia_id' => '2',
                'listador_de_frequencia_type' => 'Aaa\Aaa',
                'data_de_lancamento' => date('Y-m-d'), 
            ]);
            $frequencia = $listasDeFrequenciaService->createFrequenciaForLista($lista->getId(), [
                'is_presente' => true,
                'titulo' => 'Bbb 2',
                'frequenciavel_id' => '2',
                'frequenciavel_type' => 'Bbb\Bbb',
            ]);
            $result = $listasDeFrequenciaService->setPresencaFromFrequencia($frequencia->getId(), false);
            if ($result === true) {
                echo 'Teste de atualização bem-sucedido' . PHP_EOL;
            } else {
                throw new Exception('Foi esperado que o retorno de setPresencaFromFrequencia fosse true');
            }
        } catch (Throwable $throwable) {
            echo $throwable->getMessage() . PHP_EOL;
        }
    }
}
