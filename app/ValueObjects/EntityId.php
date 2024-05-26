<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class EntityId
{
    protected string $entityId;

    public function __construct(array $data, string $key)
    {
        $entityId = $data[$key] ?? null;
        if ($entityId === null) {
            throw new InvalidDataException("O campo '{$key}' é obrigatório");
        }
        if (is_string($entityId) === false) {
            throw new InvalidDataException("O campo '{$key}' deve ser uma string");
        }
        if (strlen($entityId) === 0) {
            throw new InvalidDataException("O campo '{$key}' não pode estar vazio");
        }
        if (strlen($entityId) > 255) {
            throw new InvalidDataException("O campo '{$key}' não pode conter mais que 255 caracteres");
        }
        $this->entityId = $entityId;
    }

    public function toString(): string
    {
        return $this->entityId;
    }
}

