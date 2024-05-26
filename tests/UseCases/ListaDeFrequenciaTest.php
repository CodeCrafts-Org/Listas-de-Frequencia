<?php

namespace CodeCrafts\ListasDeFrequencia\Tests\UseCases;

use CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers\ApplicationContainer;
use Exception;
use Throwable;

class ListaDeFrequenciaTest
{
    public function testListaDeFrequenciaCreation(): void
    {
        try {
            $applicationContainer = new ApplicationContainer;
            $listasDeFrequenciaService = $applicationContainer->makeListasDeFrequenciaService();
            $lista = $listasDeFrequenciaService->createLista([
                'titulo' => 'Aaa 3',
                'listador_de_frequencia_id' => '3',
                'listador_de_frequencia_type' => 'Aaa\Aaa',
                'data_de_lancamento' => date('Y-m-d'), 
            ]);
            if ($lista !== null) {
                echo 'Teste de criação bem-sucedido' . PHP_EOL;
            } else {
                throw new Exception('Foi esperado que o retorno de createLista fosse diferente de null');
            }
        } catch (Throwable $throwable) {
            echo $throwable->getMessage() . PHP_EOL;
        }
    }
}
