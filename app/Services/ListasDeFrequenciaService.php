<?php

namespace CodeCrafts\ListasDeFrequencia\App\Services;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\Contracts\IListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\FrequenciaEntity;
use CodeCrafts\ListasDeFrequencia\App\Entities\ListaDeFrequenciaEntity;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\ListaMustBeEmptyException;
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

    public function paginateListas(int $page = 1, int $itemsPerPage = 10): array
    {
        $paginated = $this->listaDeFrequenciaRepository->offsetPaginate($page, $itemsPerPage);

        return $paginated;
    }

    public function getLista(int $listaId): ?array
    {
        $listaDeFrequencia = $this->listaDeFrequenciaRepository->getById($listaId);
        if ($listaDeFrequencia === null) {
            return null;
        }

        return [
            'listaDeFrequencia' => $listaDeFrequencia,
            'frequencias' => $this->frequenciaRepository->listForListaDeFrequenciaId($listaId),
        ];
    }

    public function getListaByParent(string $parentId, string $parentType): ?array
    {
        $listaDeFrequencia = $this->listaDeFrequenciaRepository->getByParent($parentId, $parentType);
        if ($listaDeFrequencia === null) {
            return null;
        }
        $listaId = $listaDeFrequencia->getId();

        return [
            'listaDeFrequencia' => $listaDeFrequencia,
            'frequencias' => $this->frequenciaRepository->listForListaDeFrequenciaId($listaId),
        ];
    }

    public function getFrequenciaByParent(string $parentId, string $parentType): ?array
    {
        $frequencia = $this->frequenciaRepository->getByParent($parentId, $parentType);
        if ($frequencia === null) {
            return null;
        }

        return [
            'frequencia' => $this->frequencia,
        ];
    }

    /**
     * @throws InvalidDataException quando houverem erros quanto aos dados de criação
     */
    public function createLista(array $data): ?ListaDeFrequenciaEntity
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

    public function deleteLista(int $listaId): void
    {
        $listaDeFrequencia = $this->listaDeFrequenciaRepository->getById($listaId);
        if ($listaDeFrequencia === null) {
            throw new ListaNotFoundException($listaId);
        }
        $frequencias = $this->frequenciaRepository->listForListaDeFrequenciaId($listaId);
        $quantidadeDeFrequencias = count($frequencias);
        if ($quantidadeDeFrequencias !== 0) {
            throw new ListaMustBeEmptyException($listaId, $quantidadeDeFrequencias);
        }
        $this->listaDeFrequenciaRepository->deleteById($listaId);
    }

    public function deleteFrequencia(int $frequenciaId): bool
    {
        $this->frequenciaRepository->deleteById($frequenciaId);
    }

    // public function setFrequenciavelAsPresente(int $frequenciavelId, string $frequenciavelType): ?bool
    // {
    //     //
    // }
}