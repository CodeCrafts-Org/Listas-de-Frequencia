<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

use CodeCrafts\ListasDeFrequencia\App\Services\ListasDeFrequenciaService;
use CodeCrafts\ListasDeFrequencia\App\Exceptions\InvalidDataException;

class AdminApiController
{
    protected ListasDeFrequenciaService $listasDeFrequenciaService;

    public function __construct(ListasDeFrequenciaService $listasDeFrequenciaService)
    {
        $this->listasDeFrequenciaService = $listasDeFrequenciaService;
    } 
    
    public function indexListas(\WP_REST_Request $request): \WP_REST_Response
    {
        $paginated = $this->listasDeFrequenciaService->paginateListas(
            /* page: */ (int) $request->get_param('page')
        );

        return new \WP_REST_Response($paginated, 200);
    }

    public function createLista(\WP_REST_Request $request): \WP_REST_Response 
    {
        try {
            $lista = $this->listasDeFrequenciaService->createLista([
                'titulo' => $request->get_param('titulo'),
                'listador_de_frequencia_id' => $request->get_param('listador_de_frequencia_id'),
                'listador_de_frequencia_type' => $request->get_param('listador_de_frequencia_type'),
                'data_de_lancamento' => $request->get_param('data_de_lancamento'),
            ]);

            return new \WP_REST_Response([
                'message' => "Lista #{$id} criada com sucesso",
            ], 201);
        } catch (InvalidDataException $exception) {
            return new \WP_REST_Response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function showLista(\WP_REST_Request $request): \WP_REST_Response 
    {
        $lista = $this->listasDeFrequenciaService->getLista(
            /* listaId: */ $request->get_param('id')
        );

        if ($lista === null) {
            return new \WP_REST_Response([
                'message' => 'Lista não encontrada',
                'listaDeFrequencia' => null,
            ], 404);
        } else {
            return new \WP_REST_Response([
                'message' => "Lista #{$id} encontrada com sucesso",
                'listaDeFrequencia' => $lista,
            ], 200);
        }
    }

    public function deleteLista(\WP_REST_Request $request): \WP_REST_Response 
    {
        try {
            $this->listasDeFrequenciaService->deleteLista(
                /* listaId: */ $request->get_param('id')
            );

            return new \WP_REST_Response([
                'deleted' => true,
            ], 200);
        } catch (ListaNotFoundException $exception) {
            return new \WP_REST_Response([
                'message' => $exception->getMessage(),
            ], 404);
        } catch (ListaMustBeEmptyException $exception) {
            return new \WP_REST_Response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function createFrequenciaForLista(\WP_REST_Request $request): \WP_REST_Response 
    {
        return new \WP_REST_Response([
            'frequencia' => null,
        ], 400);
    }

    public function updatePresencaForFrequencia(\WP_REST_Request $request): \WP_REST_Response 
    {
        return new \WP_REST_Response([
            'updated' => null,
        ], 404);
    }
}