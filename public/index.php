<?php

declare(strict_types=1);

use App\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers/vite.php'; // Vite's helpers for assets loading !
require_once __DIR__ . '/../routes/web.php';

$App = new Application(dirname(__DIR__));
$App->run();
