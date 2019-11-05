<?php

namespace Roowix\App\Router;

class Route
{
    /** @var string */
    private $controller;
    /** @var array */
    private $params;

    public function __construct(string $controller, array $params)
    {
        $this->controller = $controller;
        $this->params = $params;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
