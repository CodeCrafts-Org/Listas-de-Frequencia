<?php

namespace CodeCrafts\ListasDeFrequencia\Database;

interface Migrator
{
    public function up(): string;

    public function down(): string;
}