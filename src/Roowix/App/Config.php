<?php

namespace Roowix\App;

class Config
{
    /** @var string */
    private $connectionString;
    /** @var array */
    private $routes;

    public function __construct(string $connectionString, array $routes)
    {
        $this->connectionString = $connectionString;
        $this->routes = $routes;
    }

    public function getConnectionString(): string
    {
        return $this->connectionString;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
