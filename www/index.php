<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Roowix\App\App;

$configPath = __DIR__ . '/../config/config.yml';

$postJson = file_get_contents("php://input");
$post = $postJson ? json_decode($postJson, true) : [];

(new App($configPath))->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_GET, $post);
