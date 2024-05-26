<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class Titulo
{
    protected string $titulo;

    public function __construct(array $data)
    {
        $titulo = $data['titulo'] ?? null;
        if ($titulo === null) {
            throw new InvalidDataException("O campo 'titulo' é obrigatório");
        }
        if (is_string($titulo) === false) {
            throw new InvalidDataException("O campo 'titulo' deve ser uma string");
        }
        if (strlen($titulo) === 0) {
            throw new InvalidDataException("O campo 'titulo' não pode estar vazio");
        }
        if (strlen($titulo) > 255) {
            throw new InvalidDataException("O campo 'titulo' não pode conter mais que 255 caracteres");
        }
        $this->titulo = $titulo;
    }

    public function toString(): string
    {
        return $this->titulo;
    }
}