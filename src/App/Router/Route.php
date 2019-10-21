<?php

namespace App\Router;

class Route
{
    /** @var string */
    private $controllerClass;
    /** @var array */
    private $params;

    public function __construct(string $controllerClass, array $params)
    {
        $this->controllerClass = $controllerClass;
        $this->params = $params;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
