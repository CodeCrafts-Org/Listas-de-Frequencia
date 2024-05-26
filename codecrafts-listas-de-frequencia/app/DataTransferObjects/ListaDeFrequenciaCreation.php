<?php

namespace CodeCrafts\ListasDeFrequencia\App\DataTransferObjects;

use CodeCrafts\ListasDeFrequencia\App\ValueObjects\DataDeLancamento;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityId;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityType;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\Titulo;

class ListaDeFrequenciaCreation
{
    protected Titulo $titulo;
    
    protected EntityId $listadorDeFrequenciaId;
    
    protected EntityType $listadorDeFrequenciaType;
    
    protected DataDeLancamento $dataDeLancamento;
    
    public function __construct(Titulo $titulo, EntityId $listadorDeFrequenciaId, EntityType $listadorDeFrequenciaType, DataDeLancamento $dataDeLancamento) 
    {
        $this->titulo = $titulo;
        $this->listadorDeFrequenciaId = $listadorDeFrequenciaId;
        $this->listadorDeFrequenciaType = $listadorDeFrequenciaType;
        $this->dataDeLancamento = $dataDeLancamento;
    }

    public function getTitulo(): Titulo
    {
        return $this->titulo;
    }

    public function getListadorDeFrequenciaId(): EntityId
    {
        return $this->listadorDeFrequenciaId;
    }

    public function getListadorDeFrequenciaType(): EntityType
    {
        return $this->listadorDeFrequenciaType;
    }

    public function getDataDeLancamento(): DataDeLancamento
    {
        return $this->dataDeLancamento;
    }
}