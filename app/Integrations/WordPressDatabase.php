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

    /**
     * @return bool quando houverem erros na inserção (sempre false)
     * @return int quando for bem-sucedido, indicando o número de linhas afetadas (sempre 1)
     */
    public function insert(string $table, array $data)
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

    /**
     * @return bool quando houverem erros na inserção (sempre false)
     * @return int quando for bem-sucedido, indicando o número de linhas afetadas
     */
    public function update(string $table, array $data, array $where)
    {
        return $this->connection->update($table, $data, $where, null, null);
    }

    /**
     * @return bool quando houverem erros na inserção (sempre false)
     * @return int quando for bem-sucedido, indicando o número de linhas afetadas
     */
    public function delete(string $table, array $where)
    {
        return $this->connection->delete($table, $where, null);
    }
}