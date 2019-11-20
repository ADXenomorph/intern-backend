<?php

namespace Roowix\App\Router;

class Route
{
    /** @var string */
    private $controller;
    /** @var array */
    private $params;
    /** @var bool */
    private $auth;

    public function __construct(string $controller, array $params, bool $auth)
    {
        $this->controller = $controller;
        $this->params = $params;
        $this->auth = $auth;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function requiresAuth(): bool
    {
        return $this->auth;
    }
}
