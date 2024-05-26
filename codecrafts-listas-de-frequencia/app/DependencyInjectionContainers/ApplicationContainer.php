<?php

namespace CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\Contracts\IListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataAccessObjects\FrequenciaDataAccessObject;
use CodeCrafts\ListasDeFrequencia\App\DataAccessObjects\ListaDeFrequenciaDataAccessObject;
use CodeCrafts\ListasDeFrequencia\App\DatabaseTables\FrequenciaDatabaseTable;
use CodeCrafts\ListasDeFrequencia\App\DatabaseTables\ListaDeFrequenciaDatabaseTable;
use CodeCrafts\ListasDeFrequencia\App\Integrations\WordPressDatabase;
use CodeCrafts\ListasDeFrequencia\App\Repositories\FrequenciaInMemoryRepository;
use CodeCrafts\ListasDeFrequencia\App\Repositories\FrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\Repositories\ListaDeFrequenciaInMemoryRepository;
use CodeCrafts\ListasDeFrequencia\App\Repositories\ListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\Services\ListasDeFrequenciaService;

class ApplicationContainer
{
    public function makeIFrequenciaRepository(): IFrequenciaRepository
    {
        return $this->makeFrequenciaRepository();
    }

    public function makeIListaDeFrequenciaRepository(): IListaDeFrequenciaRepository
    {
        return $this->makeListaDeFrequenciaRepository();
    }

    public function makeFrequenciaDataAccessObject(): FrequenciaDataAccessObject
    {
        $frequenciaDatabaseTable = $this->makeFrequenciaDatabaseTable();
        $wordPressDatabase = $this->makeWordPressDatabase();

        return new FrequenciaDataAccessObject($frequenciaDatabaseTable, $wordPressDatabase);
    }
    
    public function makeListaDeFrequenciaDataAccessObject(): ListaDeFrequenciaDataAccessObject
    {
        $listaDeFrequenciaDatabaseTable = $this->makeListaDeFrequenciaDatabaseTable();
        $wordPressDatabase = $this->makeWordPressDatabase();

        return new ListaDeFrequenciaDataAccessObject($listaDeFrequenciaDatabaseTable, $wordPressDatabase);
    }

    public function makeFrequenciaDatabaseTable(): FrequenciaDatabaseTable
    {
        return new FrequenciaDatabaseTable();
    }

    public function makeListaDeFrequenciaDatabaseTable(): ListaDeFrequenciaDatabaseTable
    {
        return new ListaDeFrequenciaDatabaseTable();
    }

    public function makeWordPressDatabase(): WordPressDatabase
    {
        $connection = $GLOBALS['wpdb'];
        
        return new WordPressDatabase($connection);
    }

    public function makeFrequenciaInMemoryRepository(): FrequenciaInMemoryRepository
    {
        return new FrequenciaInMemoryRepository(0, []);
    }

    public function makeFrequenciaRepository(): FrequenciaRepository
    {
        $frequenciaDataAccessObject = $this->makeFrequenciaDataAccessObject();

        return new FrequenciaRepository($frequenciaDataAccessObject);
    }

    public function makeListaDeFrequenciaInMemoryRepository(): ListaDeFrequenciaInMemoryRepository
    {
        return new ListaDeFrequenciaInMemoryRepository(0, []);
    }

    public function makeListaDeFrequenciaRepository(): ListaDeFrequenciaRepository
    {
        $listaDeFrequenciaDataAccessObject = $this->makeListaDeFrequenciaDataAccessObject();

        return new ListaDeFrequenciaRepository($listaDeFrequenciaDataAccessObject);
    }

    public function makeListasDeFrequenciaService(): ListasDeFrequenciaService
    {
        $frequenciaRepository = $this->makeIFrequenciaRepository();
        $listaDeFrequenciaRepository = $this->makeIListaDeFrequenciaRepository();

        return new ListasDeFrequenciaService($frequenciaRepository, $listaDeFrequenciaRepository);
    }
}