<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

use CodeCrafts\ListasDeFrequencia\App\Services\ListasDeFrequenciaService;

class AdminApiController
{
    protected ListasDeFrequenciaService $listasDeFrequenciaService;

    public function __construct(ListasDeFrequenciaService $listasDeFrequenciaService)
    {
        $this->listasDeFrequenciaService = $listasDeFrequenciaService;
    } 
    
    public function indexListas(WP_REST_Request $request): WP_REST_Response
    {
        return new WP_REST_Response([
            'listasDeFrequencia' => [],
        ], 200);
    }

    public function createLista(WP_REST_Request $request): WP_REST_Response 
    {
        return new WP_REST_Response([
            'listaDeFrequencia' => null,
        ], 400);
    }

    public function showLista(WP_REST_Request $request): WP_REST_Response 
    {
        return new WP_REST_Response([
            'listaDeFrequencia' => null,
        ], 404);
    }

    public function deleteLista(WP_REST_Request $request): WP_REST_Response 
    {
        return new WP_REST_Response([
            'deleted' => null,
        ], 404);
    }

    public function createFrequenciaForLista(WP_REST_Request $request): WP_REST_Response 
    {
        return new WP_REST_Response([
            'frequencia' => null,
        ], 400);
    }

    public function updatePresencaForFrequencia(WP_REST_Request $request): WP_REST_Response 
    {
        return new WP_REST_Response([
            'updated' => null,
        ], 404);
    }
}