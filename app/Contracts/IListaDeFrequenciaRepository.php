<?php

namespace CodeCrafts\ListasDeFrequencia\App\Contracts;

use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\ListaDeFrequenciaEntity;

interface IListaDeFrequenciaRepository
{
    public function listAll(): array;
    
    public function getById(int $id): ?ListaDeFrequenciaEntity;
    
    public function getByParent(string $parentId, string $parentType): ?ListaDeFrequenciaEntity;
    
    public function create(ListaDeFrequenciaCreation $listaDeFrequenciaCreation): ?ListaDeFrequenciaEntity;
    
    public function cursorPaginate(int $cursor, int $itemsPerPage);
    
    public function offsetPaginate(int $page, int $itemsPerPage);

    public function deleteById(int $id): bool;
}
