<?php

namespace CodeCrafts\ListasDeFrequencia\Includes;

class PluginDatabase
{
    protected string $migrationsPath;

    protected $wpdb;

    public function __construct(string $migrationsPath, $wpdb) {
        $this->migrationsPath = $migrationsPath;
        $this->wpdb = $wpdb;
    }

    public function up(): void
    {
        $migrationFiles = glob("{$this->migrationsPath}/*.php");
        sort($migrationFiles);

        foreach ($migrationFiles as $migration) {
            $migration = require $migration;
            $query = $migration->up();
            $this->wpdb->query($query);
        }
    }

    public function down(): void
    {
        $migrationFiles = glob("{$this->migrationsPath}/*.php");
        sort($migrationFiles);

        foreach ($migrationFiles as $migration) {
            $migration = require $migration;
            $query = $migration->down();
            $this->wpdb->query($query);
        }
    }
}