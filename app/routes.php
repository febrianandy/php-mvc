<?php

use App\Core\Router;

$router = new Router();

$router->add('users', ['controller' => 'App\Controllers\UserController', 'action' => 'index']);
$router->add('users/create', ['controller' => 'App\Controllers\UserController', 'action' => 'store']);
$router->add('users/update', ['controller' => 'App\Controllers\UserController', 'action' => 'update']);
$router->add('users/delete', ['controller' => 'App\Controllers\UserController', 'action' => 'destroy']);


