<?php

namespace CodeCrafts\ListasDeFrequencia\Database\Migrations;

use CodeCrafts\ListasDeFrequencia\Database\Migrator;

return new class implements Migrator
{
    public function migrate(): string
    {
        $query = "CREATE TABLE codecrafts_listas_de_frequencia (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            listador_de_frequencia_id VARCHAR(255) NOT NULL,
            listador_de_frequencia_type VARCHAR(255) NOT NULL,
            data_de_lancamento DATE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            UNIQUE (listador_de_frequencia_id, listador_de_frequencia_type)
        );";

        return $query;
    }

    public function rollback(): string
    {
        return "DROP TABLE IF EXISTS codecrafts_listas_de_frequencia;";
    }
};