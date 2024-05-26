<?php

namespace CodeCrafts\ListasDeFrequencia\Database;

interface Migrator
{
    public function migrate(): string;

    public function rollback(): string;
}