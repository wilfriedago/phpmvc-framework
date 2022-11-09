<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    public function __construct(array $config)
    {
        $driver = $config['driver'] ?? 'mysql';
        $host = $config['host'] ?? 'localhost';
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        $port = $config['port'] ?? '3306';

        $options = [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            parent::__construct("$driver:dbname=$database;host=$host:$port", $username, $password, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Log a message to the console
     *
     * @param string $message
     * @return void
     */
    protected function log(string $message):void
    {
        echo date('d-M-Y H:i:s') . ' - ' . $message . PHP_EOL;
    }

    /**
     * Create a migration table if not exists inside the database
     *
     * @return void
     */
    private function createMigrationsTable():void
    {
        $this->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB");
    }

    /**
     * Get applied migrations form the database
     *
     * @return array|false
     */
    private function getAppliedMigrations(): bool|array
    {
        $this->createMigrationsTable();

        $stmt = $this->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Save new migrations to inside the database
     *
     * @param array $migrations
     * @return void
     */
    private function saveMigrations(array $migrations): void
    {
        $migrationSQLString = implode(",", array_map(fn($migration) => "('$migration')", $migrations));

        $stmt = $this->prepare("INSERT INTO migrations (migration) VALUES $migrationSQLString");

        $stmt->execute();
    }

    /**
     * @return void
     */
    public function applyMigrations(): void
    {
        $migrationsFiles = scandir(Application::$MIGRATION_DIR);

        $notApplyMigrations = array_diff($migrationsFiles, $this->getAppliedMigrations());

        foreach ($notApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            $migrationClass = require_once Application::$MIGRATION_DIR . "$migration";

            $this->log("Applying $migration migration.");

            try {
                $migrationClass->up();
            } catch (Exception $e) {
                // Catching some SQL Exception
            }

            $this->log("$migration migration applied successfully !");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations has been applied !");
        }
    }
}
