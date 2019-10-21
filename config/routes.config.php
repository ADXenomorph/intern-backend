<?php

use Controller\OrdersController;
use Controller\UsersController;

$routesConfig = [
    '/api/orders' => OrdersController::class,
    '/api/orders/{id}' => OrdersController::class,
    '/api/users/' => UsersController::class,
    '/api/users/{id}' => UsersController::class,
];
