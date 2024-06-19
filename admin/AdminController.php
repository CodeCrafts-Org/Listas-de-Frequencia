<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

class AdminController
{
    public function query()
    {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            include __DIR__ . '/partials/listas-de-frequencia/index.php';
        } else {
            $listaId = (int) $id;
            include __DIR__ . '/partials/listas-de-frequencia/show.php';
        }
    }

    public function command()
    {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            include __DIR__ . '/partials/listas-de-frequencia/create.php';
        } else {
            $listaId = (int) $id;
        }
    }
}