<?php

namespace Roowix\App;

use Exception;

class Request
{
    /** @var string */
    private $method;
    /** @var array */
    private $params;

    public function __construct(string $method, array $params)
    {
        $this->method = $method;
        $this->params = $params;
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
}
