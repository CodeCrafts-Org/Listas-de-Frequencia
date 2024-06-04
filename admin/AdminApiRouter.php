<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

class AdminApiRouter
{
    protected AdminApiController $adminApiController;

    public function __construct(AdminApiController $adminApiController)
    {
        $this->adminApiController = $adminApiController;
    }

    public function registerRoutes(): void
    {
        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this->adminApiController, 'indexListas'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this->adminApiController, 'createLista'],
        ]);
        
        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this->adminApiController, 'showLista'],
        ]);
        
        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)', [
            'methods' => WP_REST_Server::DELETABLE,
            'callback' => [$this->adminApiController, 'deleteLista'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)/frequencias', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this->adminApiController, 'createFrequenciaForLista'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/frequencias/(?P<id>\d+)/presenca', [
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => [$this->adminApiController, 'updatePresencaForFrequencia'],
        ]);
    }
}
