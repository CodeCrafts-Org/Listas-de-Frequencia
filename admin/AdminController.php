<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

use CodeCrafts\ListasDeFrequencia\App\Services\ListasDeFrequenciaService;

class AdminController
{
    protected ListasDeFrequenciaService $listasDeFrequenciaService;

    public function __construct(ListasDeFrequenciaService $listasDeFrequenciaService)
    {
        $this->listasDeFrequenciaService = $listasDeFrequenciaService;
    } 
    
    public function index()
    {
        ob_start();
        $paginated = $this->listasDeFrequenciaService->paginateListas();
        include __DIR__ . '/partials/index.php';

        return ob_get_clean();
    }

    public function create()
    {
        ob_start();
        include __DIR__ . '/partials/create.php';

        return ob_get_clean();
    }
}