<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

class Presenca
{
    protected bool $isPresente;

    public function __construct(array $data)
    {
        $this->isPresente = array_key_exists('is_presente', $data);
    }

    public function toBoolean(): bool
    {
        return $this->isPresente;
    }
}