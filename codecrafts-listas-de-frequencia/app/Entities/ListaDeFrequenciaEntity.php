<?php

namespace CodeCrafts\ListasDeFrequencia\App\Entities;

use DateTimeImmutable;

class ListaDeFrequenciaEntity
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

    public function getTitulo(): string
    {
        return $this->wordPressDatabaseResult->titulo;
    }

    public function getListadorDeFrequenciaId(): int
    {
        return (int) $this->wordPressDatabaseResult->listador_de_frequencia_id;
    }

    public function getListadorDeFrequenciaType(): string
    {
        return $this->wordPressDatabaseResult->listador_de_frequencia_type;
    }

    public function getDataDeLancamento(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->wordPressDatabaseResult->data_de_lancamento);
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
}