<?php

namespace App\Response;

class JsonResponseWriter
{
    public function write(Response $response)
    {
        echo json_encode([
            'status' => $response->getStatus(),
            'message' => $response->getMessage(),
            'payload' => $response->getPayload()
        ]);
    }
}
