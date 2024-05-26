<?php

namespace CodeCrafts\ListasDeFrequencia\App\Contracts;

use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\FrequenciaEntity;

interface IFrequenciaRepository
{
    public function listAll(): array;

    public function listForListaDeFrequenciaId(int $listaDeFrequenciaId): array;
    
    public function getById(int $id): ?FrequenciaEntity;
    
    public function create(FrequenciaCreation $frequenciaCreation): ?FrequenciaEntity;
    
    public function update(int $id, array $isPresente): ?bool;
    
    public function cursorPaginate(int $cursor, int $itemsPerPage);
    
    public function offsetPaginate(int $page, int $itemsPerPage);
}
