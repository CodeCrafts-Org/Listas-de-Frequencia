<?php

namespace CodeCrafts\ListasDeFrequencia\App\Entities;

use DateTimeImmutable;
use JsonSerializable;

class FrequenciaEntity implements JsonSerializable
{
    protected object $wordPressDatabaseResult;

    public function __construct(
        object $wordPressDatabaseResult
    ) {
        $this->wordPressDatabaseResult = $wordPressDatabaseResult;
    }

    public function getId(): int
    {
        return (int) $this->wordPressDatabaseResult->id;
    }

    public function getListaDeFrequenciaId(): int
    {
        return (int) $this->wordPressDatabaseResult->lista_de_frequencia_id;
    }

    public function getIsPresente(): bool
    {
        return (bool) $this->wordPressDatabaseResult->is_presente;
    }

    public function getTitulo(): string
    {
        return $this->wordPressDatabaseResult->titulo;
    }

    public function getFrequenciavelId(): string
    {
        return $this->wordPressDatabaseResult->frequenciavel_id;
    }

    public function getFrequenciavelType(): string
    {
        return $this->wordPressDatabaseResult->frequenciavel_type;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->wordPressDatabaseResult->created_at);
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        $updatedAt = $this->wordPressDatabaseResult->updated_at;
        if ($updatedAt === null) {
            return null;
        }

        return new DateTimeImmutable($updatedAt);
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        $deletedAt = $this->wordPressDatabaseResult->deleted_at;
        if ($deletedAt === null) {
            return null;
        }

        return new DateTimeImmutable($deletedAt);
    }

    public function equals($other): ?bool
    {
        if (($other instanceof self) === false) {
            return null;
        }

        return $other->getId() === $this->getId();
    }

     public function jsonSerialize(): array
     {
        return [
            'id' => $this->getId(),
            'titulo' => $this->getTitulo(),
            'listaId' => $this->getListaDeFrequenciaId(),
            'estaPresente' => $this->getIsPresente(),
            'parentId' => $this->getFrequenciavelId(),
            'parentType' => $this->getFrequenciavelType(),
        ];
     }
}