<?php

require_once __DIR__ . "/bootstrap.php";

use Controller\OrdersController;
use Controller\UsersController;
use DB\Connection;

$dbconn = new Connection("host=localhost port=5432 dbname=roowix user=postgres password=12345");

$usersController = new UsersController($dbconn);
$ordersController = new OrdersController($dbconn);

if (strpos($_SERVER['REQUEST_URI'], '/api/users') !== false) {
    (new UsersController($dbconn))->handleRequest();
} elseif (strpos($_SERVER['REQUEST_URI'], '/api/orders') !== false) {
    (new OrdersController($dbconn))->handleRequest();
} else {
    echo json_encode(['status' => 0, 'message' => 'Hello world!', 'payload' => []]);
}
