<?php

namespace CodeCrafts\ListasDeFrequencia\App\DataAccessObjects;

use CodeCrafts\ListasDeFrequencia\App\DatabaseTables\ListaDeFrequenciaDatabaseTable;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Integrations\WordPressDatabase;

class ListaDeFrequenciaDataAccessObject
{
    protected ListaDeFrequenciaDatabaseTable $listaDeFrequenciaDatabaseTable;
    
    protected WordPressDatabase $wordPressDatabase;

    public function __construct(
        ListaDeFrequenciaDatabaseTable $listaDeFrequenciaDatabaseTable,
        WordPressDatabase $wordPressDatabase
    ) {
        $this->listaDeFrequenciaDatabaseTable = $listaDeFrequenciaDatabaseTable;
        $this->wordPressDatabase = $wordPressDatabase;
    }

    public function count(): ?int
    {
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT COUNT(*) FROM {$table}";
        $count = $this->wordPressDatabase->getVariable($query);
        if ($count === null) {
            return null;
        }

        return (int) $count;
    }

    /**
     * @return array<int,object>
     */
    public function selectAll(): array
    {
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table}";
        $results = $this->wordPressDatabase->getResults($query);
        if ($results === null) {
            return [];
        }

        return $results;
    }

    /**
     * @return array<int,object>
     */
    public function selectManyStartingFromId(int $id, int $limit): array
    {
        $primaryKey = $this->listaDeFrequenciaDatabaseTable->getPrimaryKey();
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} WHERE {$primaryKey} > {$id} ORDER BY {$primaryKey} LIMIT {$limit}";
        $results = $this->wordPressDatabase->getResults($query);
        if ($results === null) {
            return [];
        }

        return $results;
    }

    /**
     * @return array<int,object>
     */
    public function selectManyStartingFromOffset(int $offset, int $limit): array
    {
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} LIMIT {$limit} OFFSET {$offset}";
        $results = $this->wordPressDatabase->getResults($query);
        if ($results === null) {
            return [];
        }

        return $results;
    }

    public function insert(ListaDeFrequenciaCreation $listaDeFrequenciaCreation): ?int
    {
        $titulo = $listaDeFrequenciaCreation->getTitulo();
        $listadorDeFrequenciaId = $listaDeFrequenciaCreation->getListadorDeFrequenciaId();
        $listadorDeFrequenciaType = $listaDeFrequenciaCreation->getListadorDeFrequenciaType();
        $dataDeLancamento = $listaDeFrequenciaCreation->getDataDeLancamento();

        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $result = $this->wordPressDatabase->insert($table, [
            'titulo' => $titulo->toString(),
            'listador_de_frequencia_id' => $listadorDeFrequenciaId->toInteger(),
            'listador_de_frequencia_type' => $listadorDeFrequenciaType->toString(),
            'data_de_lancamento' => $dataDeLancamento->toString(),
        ]);
        if ($result === false) {
            return null;
        }
        
        return $this->wordPressDatabase->insertionId();
    }

    public function selectSingleById(int $id): ?object
    {
        $primaryKey = $this->listaDeFrequenciaDatabaseTable->getPrimaryKey();
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} WHERE {$primaryKey} = {$id}";

        return $this->wordPressDatabase->getResult($query);
    }
}
