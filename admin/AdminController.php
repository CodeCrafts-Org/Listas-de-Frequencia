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
        return 'AdminController::index';
    }

    public function create()
    {
        return 'AdminController::create';
    }
}