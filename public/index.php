<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/conn.php';

// Load routes
$router = new App\Core\Router();
require_once __DIR__ . '/../app/routes.php';

// Handle the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
