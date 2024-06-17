<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

class AdminController
{
    public function index()
    {
        include __DIR__ . '/partials/listas-de-frequencia/index.php';
    }

    public function create()
    {
        include __DIR__ . '/partials/listas-de-frequencia/create.php';
    }
}