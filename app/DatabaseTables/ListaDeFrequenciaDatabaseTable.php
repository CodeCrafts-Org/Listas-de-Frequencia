<?php

namespace CodeCrafts\ListasDeFrequencia\App\DatabaseTables;

class ListaDeFrequenciaDatabaseTable
{
    public function getName(): string
    {
        return "codecrafts_listas_de_frequencia";
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