<?php

namespace CodeCrafts\ListasDeFrequencia\App\Integrations;

class WordPressDatabase
{
    protected $connection;

    public function __construct(
        $connection
    ) {
        $this->connection = $connection;
    }

    public function getResults(string $query): ?array
    {
        return $this->connection->get_results($query);
    }

    public function getVariable(string $query): ?string
    {
        return $this->connection->get_var($query);
    }

    public function insert(string $table, array $data): int|bool
    {
        return $this->connection->insert($table, $data);
    }

    public function insertionId(): ?int
    {
        $insertionId = $this->connection->insert_id;
        if ($insertionId === 0) {
            return null;
        }

        return insertionId;
    }

    public function getResult(string $query): ?object
    {
        return $this->connection->get_row($query);
    }

    public function update(string $table, array $data, array $where): int|false
    {
        return $this->connection->update($table, $data, $where, null, null);
    }
}