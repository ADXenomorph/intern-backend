<?php

namespace Roowix\App\Config;

class Config
{
    /** @var array */
    private $properties;
    /** @var array */
    private $routes;
    /** @var array */
    private $services;

    public function __construct(array $properties, array $routes, array $services)
    {
        $this->properties = $properties;
        $this->routes = $routes;
        $this->services = $services;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
