<?php

namespace CodeCrafts\ListasDeFrequencia\App\DatabaseTables;

class FrequenciaDatabaseTable
{
    public function getName(): string
    {
        return "codecrafts_frequencias";
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