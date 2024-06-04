<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

class AdminController
{
    public function index()
    {
        include __DIR__ . '/partials/index.php';
    }

    public function create()
    {
        include __DIR__ . '/partials/create.php';
    }
}