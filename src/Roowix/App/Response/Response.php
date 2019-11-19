<?php

namespace Roowix\App\Response;

use JsonSerializable;

class Response
{
    /** @var int */
    private $status;
    /** @var string */
    private $message;
    /** @var array|JsonSerializable */
    private $payload;

    /**
     * @param int $status
     * @param string $message
     * @param array|JsonSerializable $payload
     */
    public function __construct(int $status, string $message, $payload)
    {
        $this->status = $status;
        $this->message = $message;
        $this->payload = $payload;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
