<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class EntityId
{
    protected int $entityId;

    public function __construct(array $data, string $key)
    {
        $entityId = $data[$key] ?? null;
        if ($entityId === null) {
            throw new InvalidDataException("O campo '{$key}' é obrigatório");
        }
        if (is_integer($entityId) === false) {
            throw new InvalidDataException("O campo '{$key}' deve ser um inteiro");
        }
        $this->entityId = intval($entityId);
    }

    public function toInteger(): int
    {
        return $this->entityId;
    }
}