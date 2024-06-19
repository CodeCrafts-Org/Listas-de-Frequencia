<?php

namespace CodeCrafts\ListasDeFrequencia\App\DataAccessObjects;

use CodeCrafts\ListasDeFrequencia\App\DatabaseTables\FrequenciaDatabaseTable;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Integrations\WordPressDatabase;

class FrequenciaDataAccessObject
{
    protected FrequenciaDatabaseTable $frequenciaDatabaseTable;
    
    protected WordPressDatabase $wordPressDatabase;

    public function __construct(
        FrequenciaDatabaseTable $frequenciaDatabaseTable,
        WordPressDatabase $wordPressDatabase
    ) {
        $this->frequenciaDatabaseTable = $frequenciaDatabaseTable;
        $this->wordPressDatabase = $wordPressDatabase;
    }

    public function count(): ?int
    {
        $table = $this->frequenciaDatabaseTable->getName();
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
        $table = $this->frequenciaDatabaseTable->getName();
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
        $primaryKey = $this->frequenciaDatabaseTable->getPrimaryKey();
        $table = $this->frequenciaDatabaseTable->getName();
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
        $table = $this->frequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} LIMIT {$limit} OFFSET {$offset}";
        $results = $this->wordPressDatabase->getResults($query);
        if ($results === null) {
            return [];
        }

        return $results;
    }

    public function insert(FrequenciaCreation $frequenciaCreation): ?int
    {
        $listaDeFrequenciaId = $frequenciaCreation->getListaDeFrequenciaId();
        $titulo = $frequenciaCreation->getTitulo();
        $frequenciavelId = $frequenciaCreation->getFrequenciavelId();
        $frequenciavelType = $frequenciaCreation->getFrequenciavelType();
        $isPresente = $frequenciaCreation->getIsPresente();
        
        $table = $this->frequenciaDatabaseTable->getName();
        $result = $this->wordPressDatabase->insert($table, [
            'lista_de_frequencia_id' => $listaDeFrequenciaId->toInteger(),
            'titulo' => $titulo->toString(),
            'frequenciavel_id' => $frequenciavelId->toString(),
            'frequenciavel_type' => $frequenciavelType->toString(),
            'is_presente' => $isPresente->toBoolean(),
        ]);
        if ($result === false) {
            return null;
        }
        
        return $this->wordPressDatabase->insertionId();
    }

    public function selectSingleById(int $id): ?object
    {
        $primaryKey = $this->frequenciaDatabaseTable->getPrimaryKey();
        $table = $this->frequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} WHERE {$primaryKey} = {$id}";

        return $this->wordPressDatabase->getResult($query);
    }

    public function selectManyWhereListaDeFrequenciaIdEqualsTo(int $listaDeFrequenciaId): array
    {
        $table = $this->frequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} WHERE lista_de_frequencia_id = {$listaDeFrequenciaId}";
        $results = $this->wordPressDatabase->getResults($query);
        if ($results === null) {
            return [];
        }

        return $results;
    }

    /**
     * @return bool quando houverem erros na inserção (sempre false)
     * @return int quando for bem-sucedido, indicando o número de linhas afetadas
     */
    public function updateSingleById(int $id, array $isPresente, array $updatedAt)
    {
        $primaryKey = $this->frequenciaDatabaseTable->getPrimaryKey();
        $table = $this->frequenciaDatabaseTable->getName();
        $data = array_merge(
            $isPresente,
            $updatedAt
        );
        $where = [
            $primaryKey => $id,
        ];
            
        return $this->wordPressDatabase->update($table, $data, $where);
    }

    public function selectSingleByParentIdAndParentType(string $parentId, string $parentType): ?object
    {
        $table = $this->listaDeFrequenciaDatabaseTable->getName();
        $query = "SELECT * FROM {$table} WHERE frequenciavel_id = '{$parentId}' AND frequenciavel_type = '{$parentType}'";

        return $this->wordPressDatabase->getResult($query);
    }
}
