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
        $view = include __DIR__ . '/partials/index.php';

        return $view;
    }

    public function create()
    {
        $view = include __DIR__ . '/partials/create.php';
        
        return $view;
    }
}