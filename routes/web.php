<?php

use App\Core\Router;
use App\Controllers\HomeController;

// List of all web routes
Router::get('/', [HomeController::class, 'index']);
