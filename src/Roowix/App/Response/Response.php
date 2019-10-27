<?php

namespace Roowix\App\Response;

class Response
{
    /** @var int */
    private $status;
    /** @var string */
    private $message;
    /** @var array */
    private $payload;

    public function __construct(int $status, string $message, array $payload)
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

    public function getPayload(): array
    {
        return $this->payload;
    }
}
