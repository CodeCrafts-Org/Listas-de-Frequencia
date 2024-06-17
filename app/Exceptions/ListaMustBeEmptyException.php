<?php

namespace CodeCrafts\ListasDeFrequencia\App\Exceptions;

use Exception;

class ListaMustBeEmptyException extends Exception
{
    protected int $id;
    protected int $quantidadeDeFrequencias;

    public function __construct(int $id, int $quantidadeDeFrequencias)
    {
        parent::__construct("A Lista#{$id} deve estar vazia ({$quantidadeDeFrequencias} frequências encontradas)");
        
        $this->id = $id;
        $this->quantidadeDeFrequencias = $quantidadeDeFrequencias;
    }
}
