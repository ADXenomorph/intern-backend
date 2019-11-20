<?php

namespace Roowix\App;

use Exception;

class Request
{
    /** @var string */
    private $method;
    /** @var array */
    private $params;
    /** @var array */
    private $headers;
    /** @var array */
    private $authPayload;

    public function __construct(string $method, array $params, array $headers)
    {
        $this->method = $method;
        $this->params = $params;
        $this->headers = $headers;
    }

    public function getAuthPayload(): array
    {
        return $this->authPayload;
    }

    public function setAuthPayload(array $authPayload): self
    {
        $this->authPayload = $authPayload;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws Exception
     */
    public function requireParam(string $name)
    {
        if (!$this->has($name)) {
            throw new Exception('Required parameter missing: ' . $name);
        }

        return $this->params[$name];
    }

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getParam(string $name, $default = null)
    {
        return $this->has($name)
            ? $this->params[$name]
            : $default;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->params);
    }

    public function all(): array
    {
        return $this->params;
    }

    /**
     * @param string[] $names
     *
     * @return array
     */
    public function allExcept(array $names): array
    {
        return array_diff_assoc($this->all(), array_flip($names));
    }

    public function hasHeader(string $name): bool
    {
        return array_key_exists($name, $this->headers);
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name];
    }
}
