<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class ForeignId
{
    protected int $foreignId;

    public function __construct(array $data, string $key)
    {
        $foreignId = $data[$key] ?? null;
        if ($foreignId === null) {
            throw new InvalidDataException("O campo '{$key}' é obrigatório");
        }
        if (is_integer($foreignId) === false) {
            throw new InvalidDataException("O campo '{$key}' deve ser um inteiro");
        }
        $this->foreignId = intval($foreignId);
    }

    public function toInteger(): int
    {
        return $this->foreignId;
    }
}