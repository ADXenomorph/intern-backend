<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.config.php';

use App\App;
use App\Config;

$config = new Config(
    "host=localhost port=5432 dbname=roowix user=postgres password=12345",
    $routesConfig
);
$postJson = file_get_contents("php://input");
$post = json_decode($postJson, true);
(new App($config))->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_GET, $post);
