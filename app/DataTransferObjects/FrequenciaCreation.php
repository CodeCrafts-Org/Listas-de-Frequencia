<?php

namespace CodeCrafts\ListasDeFrequencia\App\DataTransferObjects;

use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityId;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityType;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\Presenca;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\Titulo;

class FrequenciaCreation
{
    protected EntityId $listaDeFrequenciaId;
    
    protected Presenca $isPresente;
    
    protected Titulo $titulo;
    
    protected EntityId $frequenciavelId;
    
    protected EntityType $frequenciavelType;

    public function __construct(EntityId $listaDeFrequenciaId, Presenca $isPresente, Titulo $titulo, EntityId $frequenciavelId, EntityType $frequenciavelType) 
    {
        $this->listaDeFrequenciaId = $listaDeFrequenciaId;
        $this->isPresente = $isPresente;
        $this->titulo = $titulo;
        $this->frequenciavelId = $frequenciavelId;
        $this->frequenciavelType = $frequenciavelType;
    }

    public function getListaDeFrequenciaId(): EntityId
    {
        return $this->listaDeFrequenciaId;
    }

    public function getIsPresente(): Presenca
    {
        return $this->isPresente;
    }

    public function getTitulo(): Titulo
    {
        return $this->titulo;
    }

    public function getFrequenciavelId(): EntityId
    {
        return $this->frequenciavelId;
    }

    public function getFrequenciavelType(): EntityType
    {
        return $this->frequenciavelType;
    }
}