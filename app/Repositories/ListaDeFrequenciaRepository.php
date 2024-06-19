<?php

namespace CodeCrafts\ListasDeFrequencia\App\Repositories;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataAccessObjects\ListaDeFrequenciaDataAccessObject;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\ListaDeFrequenciaEntity;

class ListaDeFrequenciaRepository implements IListaDeFrequenciaRepository
{
    protected ListaDeFrequenciaDataAccessObject $listaDeFrequenciaDataAccessObject;

    public function __construct(
        ListaDeFrequenciaDataAccessObject $listaDeFrequenciaDataAccessObject
    ) {
        $this->listaDeFrequenciaDataAccessObject = $listaDeFrequenciaDataAccessObject;
    }

    public function listAll(): array
    {
        return $this->listaDeFrequenciaDataAccessObject->selectAll();
    }

    public function getById(int $id): ?ListaDeFrequenciaEntity
    {
        $result = $this->listaDeFrequenciaDataAccessObject->selectSingleById($id);
        if ($result === null) {
            return null;
        }

        return new ListaDeFrequenciaEntity($result);
    }

    public function getByParent(string $parentId, string $parentType): ?ListaDeFrequenciaEntity
    {
        $result = $this->listaDeFrequenciaDataAccessObject->selectSingleByParentIdAndParentType($id);
        if ($result === null) {
            return null;
        }

        return new ListaDeFrequenciaEntity($result);
    }

    public function create(ListaDeFrequenciaCreation $listaDeFrequenciaCreation): ?ListaDeFrequenciaEntity
    {
        $listaDeFrequenciaId = $this->listaDeFrequenciaDataAccessObject->insert($listaDeFrequenciaCreation);
        if ($listaDeFrequenciaId === null) {
            return null;
        }

        return $this->getById($listaDeFrequenciaId);
    }

    /**
     * @return Paginated<ListaDeFrequenciaEntity>
     */
    public function cursorPaginate(int $cursor, int $itemsPerPage)
    {
        $id = $cursor;
        $limit = $itemsPerPage;
        $results = $this->listaDeFrequenciaDataAccessObject->selectManyStartingFromId($id, $limit);

        return [
            'totalPages' => ceil($this->listaDeFrequenciaDataAccessObject->count() / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_map(fn (object $result): ListaDeFrequenciaEntity => new ListaDeFrequenciaEntity($result), $results),
        ];
    }

    /**
     * @return Paginated<ListaDeFrequenciaEntity>
     */
    public function offsetPaginate(int $page, int $itemsPerPage)
    {
        $offset = ($page - 1) * $itemsPerPage;
        $limit = $itemsPerPage;
        $results = $this->listaDeFrequenciaDataAccessObject->selectManyStartingFromOffset($offset, $limit);

        return [
            'totalPages' => ceil($this->listaDeFrequenciaDataAccessObject->count() / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_map(fn (object $result): ListaDeFrequenciaEntity => new ListaDeFrequenciaEntity($result), $results),
        ];
    }

    public function deleteById(int $id): bool
    {
         $result = $this->listaDeFrequenciaDataAccessObject->deleteSingleById($id);
         if ($result === null) {
            return false;
         }

         return $result;
    }
}