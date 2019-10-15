<?php

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && $error['type'] === E_ERROR) {
        echo json_encode(['status' => 500, 'message' => $error, 'payload' => []]);
    }
});

set_exception_handler(function (\Exception $ex) {
    echo json_encode(['status' => 500, 'message' => $ex->getMessage(), 'payload' => []]);
});

spl_autoload_register(function ($className) {
    $filename = __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';

    require $filename;
});
