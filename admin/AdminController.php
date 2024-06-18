<?php

namespace CodeCrafts\ListasDeFrequencia\AdminView;

class AdminController
{
    public function query()
    {
        $queryVar = get_query_var(
            /* key: */ 'id', 
            /* default: */ null
        );
        if ($queryVar === null) {
            include __DIR__ . '/partials/listas-de-frequencia/index.php';
        } else {
            $listaId = (int) $queryVar;
            include __DIR__ . '/partials/listas-de-frequencia/show.php';
        }
    }

    public function command()
    {
        include __DIR__ . '/partials/listas-de-frequencia/create.php';
    }
}