<?php

namespace CodeCrafts\ListasDeFrequencia\Tests;

require __DIR__ . '/../vendor/autoload.php';

use CodeCrafts\ListasDeFrequencia\Tests\UseCases\FrequenciaTest;
use CodeCrafts\ListasDeFrequencia\Tests\UseCases\ListaDeFrequenciaTest;

$frequenciaTest = new FrequenciaTest();
$frequenciaTest->testFrequenciaCreation();
$frequenciaTest->testPresencaUpdateOnFrequencia();

$listaDeFrequenciaTest = new ListaDeFrequenciaTest();
$listaDeFrequenciaTest->testListaDeFrequenciaCreation();