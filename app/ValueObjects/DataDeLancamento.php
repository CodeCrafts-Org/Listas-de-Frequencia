<?php

namespace CodeCrafts\ListasDeFrequencia\App\ValueObjects;

use DateTimeImmutable;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class DataDeLancamento
{
    protected string $dataDeLancamento;

    public function __construct(array $data)
    {
        $dataDeLancamento = $data['data_de_lancamento'] ?? null;
        if ($dataDeLancamento === null) {
            throw new InvalidDataException("O campo 'data_de_lancamento' é obrigatório");
        }
        $resultado = DateTimeImmutable::createFromFormat('Y-m-d', $dataDeLancamento);
        if ($resultado === false) {
            throw new InvalidDataException("O campo 'data_de_lancamento' deve ser uma data válida (Y-m-d)");
        }
        $this->dataDeLancamento = $dataDeLancamento;
    }

    public function toString(): string
    {
        return $this->dataDeLancamento;
    }
}