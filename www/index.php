<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Roowix\App\App;

$configPath = __DIR__ . '/../config/config.yml';

$postJson = file_get_contents("php://input");
$post = $postJson ? json_decode($postJson, true) : [];

function getHeaders()
{
    if (!is_array($_SERVER)) {
        return [];
    }

    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

(new App($configPath))->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_GET, $post, getHeaders());
