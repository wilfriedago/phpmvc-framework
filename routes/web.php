<?php

use App\Core\Router;

// List of all web routes
Router::get('/', function () {
    return 'Hello World';
});

Router::get('/about', function () {
    return 'About Page';
});

Router::post('/contact', function () {
    return 'Contact Post';
});
