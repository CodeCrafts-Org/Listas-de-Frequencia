<?php

namespace CodeCrafts\ListasDeFrequencia\App\Repositories;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\FrequenciaEntity;

class FrequenciaInMemoryRepository implements IFrequenciaRepository
{
    protected int $autoincrement;

    protected array $frequencias;

    public function __construct(
        int $autoincrement,
        array $frequencias
    ) {
        $this->autoincrement = $autoincrement;
        $this->frequencias = $frequencias;
    }

    public function listAll(): array
    {
        return $this->frequencias;
    }

    public function listForListaDeFrequenciaId(int $listaDeFrequenciaId): array
    {
        return array_filter($this->frequencias, function (FrequenciaEntity $frequencia) use ($listaDeFrequenciaId): bool {
            return $frequencia->getListaDeFrequenciaId() === $listaDeFrequenciaId;
        });
    }

    public function getById(int $id): ?FrequenciaEntity
    {
        foreach ($this->frequencias as $frequencia) {
            if ($frequencia->getId() === $id) {
                return $frequencia;
            }
        }

        return null;
    }

    public function create(FrequenciaCreation $frequenciaCreation): ?FrequenciaEntity
    {
        $this->autoincrement += 1;

        $frequenciaEntity = new FrequenciaEntity((object) [
            'id' => $this->autoincrement,
            'lista_de_frequencia_id' => $frequenciaCreation->getListaDeFrequenciaId()->toInteger(),
            'titulo' => $frequenciaCreation->getTitulo()->toString(),
            'frequenciavel_id' => $frequenciaCreation->getFrequenciavelId()->toString(),
            'frequenciavel_type' => $frequenciaCreation->getFrequenciavelType()->toString(),
            'is_presente' => $frequenciaCreation->getIsPresente()->toBoolean(),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => null,
            'deleted_at' => null,
        ]);
        $this->frequencias[] = $frequenciaEntity;

        return $frequenciaEntity;
    }

    /**
     * @return Paginated<FrequenciaEntity>
     */
    public function cursorPaginate(int $cursor, int $itemsPerPage)
    {
        $results = array_filter($this->frequencias, function (FrequenciaEntity $frequencia) use ($cursor): bool {
            return $frequencia->getId() > $cursor;
        });

        return [
            'totalPages' => ceil(count($this->frequencias) / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_slice($results, 0, $itemsPerPage),
        ];
    }

    /**
     * @return Paginated<FrequenciaEntity>
     */
    public function offsetPaginate(int $page, int $itemsPerPage)
    {
        $offset = ($page - 1) * $itemsPerPage;

        return [
            'totalPages' => ceil(count($this->frequencias) / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_slice($this->frequencias, $offset, $itemsPerPage),
        ];
    }

    public function update(int $id, array $isPresente): ?bool
    {
        $resultado = $this->getById($id);
        if ($resultado === null) {
            return null;
        }
        $index = null;
        foreach ($this->frequencias as $key => $frequencia) {
            if ($frequencia->getId() === $id) {
                $index = $key;
            }
        }
        $this->frequencias[$index] = new FrequenciaEntity((object) [
            'id' => $frequencia->getId(),
            'lista_de_frequencia_id' => $frequencia->getListaDeFrequenciaId(),
            'titulo' => $frequencia->getTitulo(),
            'frequenciavel_id' => $frequencia->getFrequenciavelId(),
            'frequenciavel_type' => $frequencia->getFrequenciavelType(),
            'is_presente' => $isPresente['is_presente'] ?? $frequencia->getIsPresente(),
            'created_at' => $frequencia->getCreatedAt()->format('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
            'deleted_at' => $frequencia->getDeletedAt() !== null ? $frequencia->getDeletedAt()->format('Y-m-d h:i:s') : null,
        ]);

        return true;
    }
}
