<?php

namespace CodeCrafts\ListasDeFrequencia\Database\Migrations;

use CodeCrafts\ListasDeFrequencia\Database\Migrator;

return new class implements Migrator
{
    public function migrate(): string
    {
        $query = "CREATE TABLE codecrafts_frequencias (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            lista_de_frequencia_id BIGINT UNSIGNED NOT NULL,
            is_presente BOOLEAN DEFAULT FALSE,
            titulo VARCHAR(255) NOT NULL,
            frequenciavel_id VARCHAR(255) NOT NULL,
            frequenciavel_type VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL,
            deleted_at TIMESTAMP NULL,
            UNIQUE (frequenciavel_id, frequenciavel_type),
            FOREIGN KEY (lista_de_frequencia_id) REFERENCES codecrafts_listas_de_frequencia(id)
        );";

        return $query;
    }

    public function rollback(): string
    {
        return "DROP TABLE IF EXISTS codecrafts_frequencias;";
    }
};