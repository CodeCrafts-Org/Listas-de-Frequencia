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
        $paginated = $this->listasDeFrequenciaService->paginateListas();
        include __DIR__ . '/partials/index.php';
    }

    public function create()
    {
        include __DIR__ . '/partials/create.php';
    }
}