<?php

namespace CodeCrafts\ListasDeFrequencia\App\DatabaseTables;

class FrequenciaDatabaseTable
{
    protected $connection;

    public function __construct(
        $connection
    ) {
        $this->connection = $connection;
    }

    public function getName(): string
    {
        return "{$this->connection->prefix}frequencias";
    }

    public function getPrimaryKey(): string
    {
        return 'id';
    }

    public function getColumns(): array
    {
        return [
            $this->getPrimaryKey(),
            'lista_de_frequencia_id',
            'is_presente',
            'titulo',
            'frequenciavel_id',
            'frequenciavel_type',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}