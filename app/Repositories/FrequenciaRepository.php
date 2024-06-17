<?php

namespace CodeCrafts\ListasDeFrequencia\App\Repositories;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataAccessObjects\FrequenciaDataAccessObject;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\FrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\FrequenciaEntity;

class FrequenciaRepository implements IFrequenciaRepository
{
    protected FrequenciaDataAccessObject $frequenciaDataAccessObject;

    public function __construct(
        FrequenciaDataAccessObject $frequenciaDataAccessObject
    ) {
        $this->frequenciaDataAccessObject = $frequenciaDataAccessObject;
    }

    public function listAll(): array
    {
        $results = $this->frequenciaDataAccessObject->selectAll();

        return array_map(fn (object $result): FrequenciaEntity => new FrequenciaEntity($result), $results);
    }

    public function listForListaDeFrequenciaId(int $listaDeFrequenciaId): array
    {
        $results = $this->frequenciaDataAccessObject->selectManyWhereListaDeFrequenciaIdEqualsTo(
            $listaDeFrequenciaId
        );

        return array_map(fn (object $result): FrequenciaEntity => new FrequenciaEntity($result), $results);
    }

    public function getById(int $id): ?FrequenciaEntity
    {
        $result = $this->frequenciaDataAccessObject->selectSingleById($id);
        if ($result === null) {
            return null;
        }

        return new FrequenciaEntity($result);
    }

    public function create(FrequenciaCreation $frequenciaCreation): ?FrequenciaEntity
    {
        $frequenciaId = $this->frequenciaDataAccessObject->insert($frequenciaCreation);
        if ($frequenciaId === null) {
            return null;
        }

        return $this->getById($frequenciaId);
    }

    /**
     * @return Paginated<FrequenciaEntity>
     */
    public function cursorPaginate(int $cursor, int $itemsPerPage)
    {
        $id = $cursor;
        $limit = $itemsPerPage;
        $results = $this->frequenciaDataAccessObject->selectManyStartingFromId($id, $limit);

        return [
            'totalPages' => ceil($this->frequenciaDataAccessObject->count() / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_map(fn (object $result): FrequenciaEntity => new FrequenciaEntity($result), $results),
        ];
    }

    /**
     * @return Paginated<FrequenciaEntity>
     */
    public function offsetPaginate(int $page, int $itemsPerPage)
    {
        $offset = ($page - 1) * $itemsPerPage;
        $limit = $itemsPerPage;
        $results = $this->frequenciaDataAccessObject->selectManyStartingFromOffset($offset, $limit);

        return [
            'totalPages' => ceil($this->frequenciaDataAccessObject->count() / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_map(fn (object $result): FrequenciaEntity => new FrequenciaEntity($result), $results),
        ];
    }

    public function update(int $id, array $isPresente): ?bool
    {
        $result = $this->frequenciaDataAccessObject->updateSingleById($id, $isPresente, [
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
        if ($result === false) {
            return null;
        }

        return $result !== 0;
    }
}