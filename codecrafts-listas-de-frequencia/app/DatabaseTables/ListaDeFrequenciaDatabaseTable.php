<?php

namespace CodeCrafts\ListasDeFrequencia\App\DatabaseTables;

class ListaDeFrequenciaDatabaseTable
{
    protected $connection;

    public function __construct(
        $connection
    ) {
        $this->connection = $connection;
    }

    public function getName(): string
    {
        return "{$this->connection->prefix}listas_de_frequencia";
    }

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function getColumns(): array
    {
        return [
            $this->getPrimaryKey(),
            'titulo',
            'listador_de_frequencia_id',
            'listador_de_frequencia_type',
            'data_de_lancamento',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}