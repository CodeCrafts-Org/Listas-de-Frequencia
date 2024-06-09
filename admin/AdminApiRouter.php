<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

use CodeCrafts\ListasDeFrequencia\App\DependencyInjectionContainers\ApplicationContainer;

class AdminApiRouter
{
    protected ApplicationContainer $applicationContainer;

    public function __construct(ApplicationContainer $applicationContainer)
    {
        $this->applicationContainer = $applicationContainer;
    }

    public function registerRoutes(): void
    {
		$listasDeFrequenciaService = $this->applicationContainer->makeListasDeFrequenciaService();
		$adminApiController = new AdminApiController($listasDeFrequenciaService);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas', [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$adminApiController, 'indexListas'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas', [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$adminApiController, 'createLista'],
        ]);
        
        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)', [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [$adminApiController, 'showLista'],
        ]);
        
        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)', [
            'methods' => \WP_REST_Server::DELETABLE,
            'callback' => [$adminApiController, 'deleteLista'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/listas/(?P<id>\d+)/frequencias', [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$adminApiController, 'createFrequenciaForLista'],
        ]);

        register_rest_route('codecrafts/listas-de-frequencia/v1', '/frequencias/(?P<id>\d+)/presenca', [
            'methods' => \WP_REST_Server::EDITABLE,
            'callback' => [$adminApiController, 'updatePresencaForFrequencia'],
        ]);
    }
}
