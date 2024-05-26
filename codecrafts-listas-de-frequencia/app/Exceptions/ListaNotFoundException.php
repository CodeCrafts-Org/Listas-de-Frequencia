<?php

namespace CodeCrafts\ListasDeFrequencia\App\Exceptions;

use Exception;

class ListaNotFoundException extends Exception
{
    protected int $id;

    public function __construct(int $id)
    {
        parent::__construct("Lista não encontrada para o ID #{$id}");
        
        $this->id = $id;
    }
}
