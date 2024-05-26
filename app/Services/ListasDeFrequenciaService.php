<?php

namespace CodeCrafts\ListasDeFrequencia\App\Services;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\Contracts\IListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\FrequenciaEntity;
use CodeCrafts\ListasDeFrequencia\App\Entities\ListaDeFrequenciaEntity;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\ListaNotFoundException;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\DataDeLancamento;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityId;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\EntityType;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\ForeignId;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\Presenca;
use CodeCrafts\ListasDeFrequencia\App\ValueObjects\Titulo;

class ListasDeFrequenciaService
{
    protected IFrequenciaRepository $frequenciaRepository;
    
    protected IListaDeFrequenciaRepository $listaDeFrequenciaRepository;

    public function __construct(
        IFrequenciaRepository $frequenciaRepository,
        IListaDeFrequenciaRepository $listaDeFrequenciaRepository
    ) {
        $this->frequenciaRepository = $frequenciaRepository;
        $this->listaDeFrequenciaRepository = $listaDeFrequenciaRepository;
    }

    public function getLista(int $listaId): ?array
    {
        $listaDeFrequencia = $this->listaDeFrequenciaRepository->getById($listaId);
        if ($listaDeFrequencia === null) {
            return null;
        }

        return [
            'titulo' => $listaDeFrequencia->getTitulo(),
            'dataDeLancamento' => $listaDeFrequencia->getDataDeLancamento()->format('Y-m-d'),
            'listadorId' => $listaDeFrequencia->getListadorDeFrequenciaId(),
            'listadorType' => $listaDeFrequencia->getListadorDeFrequenciaType(),
            'frequencias' => $this->frequenciaRepository->listForListaDeFrequenciaId($listaId),
        ];
    }

    /**
     * @throws InvalidDataException quando houverem erros quanto aos dados de criação
     */
    public function createLista(array $data): ListaDeFrequenciaEntity
    {
        $listaDeFrequenciaCreation = new ListaDeFrequenciaCreation(
            new Titulo($data),
            new EntityId($data, 'listador_de_frequencia_id'),
            new EntityType($data, 'listador_de_frequencia_type'),
            new DataDeLancamento($data)
        );

        return $this->listaDeFrequenciaRepository->create($listaDeFrequenciaCreation);
    }

    /**
     * @throws ListaNotFoundException quando não existir lista para o Id
     * @throws InvalidDataException quando houverem erros quanto aos dados de criação
     */
    public function createFrequenciaForLista(int $listaId, array $data): FrequenciaEntity
    {
        $listaDeFrequencia = $this->listaDeFrequenciaRepository->getById($listaId);
        if ($listaDeFrequencia === null) {
            throw new ListaNotFoundException($listaId);
        }
        $frequenciaCreation = new FrequenciaCreation(
            new ForeignId(['lista_de_frequencia_id' => $listaId], 'lista_de_frequencia_id'),
            new Presenca($data),
            new Titulo($data),
            new EntityId($data, 'frequenciavel_id'),
            new EntityType($data, 'frequenciavel_type')
        );

        return $this->frequenciaRepository->create($frequenciaCreation);
    }

    /**
     * @return null quando não existir frequência
     * @return bool quando a frequência for ou não atualizada com sucesso
     */
    public function setPresencaFromFrequencia(int $frequenciaId, bool $isPresente): ?bool
    {
        $frequencia = $this->frequenciaRepository->getById($frequenciaId);
        if ($frequencia === null) {
            return null;
        }
        if ($frequencia->getIsPresente() === $isPresente) {
            return false;
        }

        return $this->frequenciaRepository->update($frequenciaId, ['is_presente' => $isPresente]);
    }

    // public function setFrequenciavelAsPresente(int $frequenciavelId, string $frequenciavelType): ?bool
    // {
    //     //
    // }
}