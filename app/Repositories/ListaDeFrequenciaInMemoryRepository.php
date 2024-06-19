<?php

namespace CodeCrafts\ListasDeFrequencia\App\Repositories;

use CodeCrafts\ListasDeFrequencia\App\Contracts\IListaDeFrequenciaRepository;
use CodeCrafts\ListasDeFrequencia\App\DataTransferObjects\ListaDeFrequenciaCreation;
use CodeCrafts\ListasDeFrequencia\App\Entities\ListaDeFrequenciaEntity;

class ListaDeFrequenciaInMemoryRepository implements IListaDeFrequenciaRepository
{
    protected int $autoincrement;

    protected array $listasDeFrequencia;

    public function __construct(
        int $autoincrement,
        array $listasDeFrequencia
    ) {
        $this->autoincrement = $autoincrement;
        $this->listasDeFrequencia = $listasDeFrequencia;
    }

    public function listAll(): array
    {
        return $this->listasDeFrequencia;
    }

    public function getById(int $id): ?ListaDeFrequenciaEntity
    {
        foreach ($this->listasDeFrequencia as $listaDeFrequencia) {
            if ($listaDeFrequencia->getId() === $id) {
                return $listaDeFrequencia;
            }
        }

        return null;
    }

    public function getByParent(string $parentId, string $parentType): ?ListaDeFrequenciaEntity
    {
        return null;
    }

    public function create(ListaDeFrequenciaCreation $listaDeFrequenciaCreation): ?ListaDeFrequenciaEntity
    {
        $this->autoincrement += 1;

        $listaDeFrequenciaEntity = new ListaDeFrequenciaEntity((object) [
            'id' => $this->autoincrement,
            'titulo' => $listaDeFrequenciaCreation->getTitulo()->toString(),
            'listador_de_frequencia_id' => $listaDeFrequenciaCreation->getListadorDeFrequenciaId()->toString(),
            'listador_de_frequencia_type' => $listaDeFrequenciaCreation->getListadorDeFrequenciaType()->toString(),
            'data_de_lancamento' => $listaDeFrequenciaCreation->getDataDeLancamento()->toString(),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => null,
            'deleted_at' => null,
        ]);
        $this->listasDeFrequencia[] = $listaDeFrequenciaEntity;

        return $listaDeFrequenciaEntity;
    }

    /**
     * @return Paginated<ListaDeFrequenciaEntity>
     */
    public function cursorPaginate(int $cursor, int $itemsPerPage)
    {
        $results = array_filter($this->listasDeFrequencia, function (ListaDeFrequenciaEntity $listaDeFrequencia) use ($cursor): bool {
            return $listaDeFrequencia->getId() > $cursor;
        });

        return [
            'totalPages' => ceil(count($this->listasDeFrequencia) / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_slice($results, 0, $itemsPerPage),
        ];
    }

    /**
     * @return Paginated<ListaDeFrequenciaEntity>
     */
    public function offsetPaginate(int $page, int $itemsPerPage)
    {
        $offset = ($page - 1) * $itemsPerPage;

        return [
            'totalPages' => ceil(count($this->listasDeFrequencia) / $itemsPerPage),
            'itemsPerPage' => $itemsPerPage,
            'items' => array_slice($this->listasDeFrequencia, $offset, $itemsPerPage),
        ];
    }
}
