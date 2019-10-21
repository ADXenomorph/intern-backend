<?php

use Controller\OrdersController;
use Controller\UsersController;

$routesConfig = [
    '/api/orders' => OrdersController::class,
    '/api/orders/{order_id}' => OrdersController::class,
    '/api/users/' => UsersController::class,
    '/api/users/{user_id}' => UsersController::class,
];
