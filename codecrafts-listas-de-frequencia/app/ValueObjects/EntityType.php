<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class EntityType
{
    protected string $entityType;

    public function __construct(array $data, string $key)
    {
        $entityType = $data[$key] ?? null;
        if ($entityType === null) {
            throw new InvalidDataException("O campo '{$key}' é obrigatório");
        }
        if (is_string($entityType) === false) {
            throw new InvalidDataException("O campo '{$key}' deve ser uma string");
        }
        if (strlen($entityType) === 0) {
            throw new InvalidDataException("O campo '{$key}' não pode estar vazio");
        }
        if (strlen($entityType) > 255) {
            throw new InvalidDataException("O campo '{$key}' não pode conter mais que 255 caracteres");
        }
        $this->entityType = $entityType;
    }

    public function toString(): string
    {
        return $this->entityType;
    }
}