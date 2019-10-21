<?php

class JsonResponse
{
    public static function returnResponse(array $payload)
    {
        echo json_encode([
            'status' => 0,
            'message' => '',
            'payload' => $payload
        ]);

        exit;
    }

    public static function returnError(string $message)
    {
        echo json_encode([
            'status' => 500,
            'message' => $message,
            'payload' => []
        ]);

        exit;
    }
}
