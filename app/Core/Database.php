<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

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

        parent::__construct("$driver:dbname=$database;host=$host:$port", $username, $password);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
