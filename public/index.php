<?php

declare(strict_types=1);

use App\Core\Application;
use Dotenv\Dotenv;

require_once __DIR__ . '/helpers.php'; // Vite's helpers for assets loading !
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';

Dotenv::createImmutable(dirname(__DIR__))->load(); // Loading environment variables !

$appConfig = [
    'rootDir' => dirname(__DIR__),
    'migrationDir' => dirname(__DIR__) . "/database/migrations/",
    'db' => [
        'driver' => $_ENV['DB_DRIVER'],
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_DATABASE'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'port' => $_ENV['DB_PORT']
    ]
];

$App = new Application($appConfig);
$App->run();
