<?php

namespace Roowix\App\Router;

use Exception;

class Router
{
    /** @var array */
    private $routerConfig = [];

    public function __construct(array $routerConfig)
    {
        foreach ($routerConfig as $route => $controller) {
            $route = rtrim($route, '/');

            $regexRoute = $route;
            $regexRoute = str_replace('/', '\/', $regexRoute);
            $regexRoute = preg_replace('/{[^{}]*}/', '[0-9a-zA-Z-_]*', $regexRoute);
            $regexRoute = '/^' . $regexRoute . '\/?$/';
            $this->routerConfig[$route] = [
                'controller' => $controller,
                'regex' => $regexRoute,
                'route' => $route
            ];
        }
    }

    public function parse(string $uri): Route
    {
        $route = $this->getRoute($uri);

        return new Route($route['controller'], $this->getParams($uri, $route['route']));
    }

    private function getRoute(string $uri): array
    {
        foreach ($this->routerConfig as $path => $route) {
            preg_match($route['regex'], $uri, $results);

            if ($results && $results[0]) {
                return $route;
            }
        }

        throw new Exception("Route not found: " . $uri);
    }

    private function getParams(string $uri, string $route): array
    {
        $uriPieces = explode('/', trim($uri, '/'));
        $routePieces = explode('/', trim($route, '/'));

        if (count($uriPieces) !== count($routePieces)) {
            throw new Exception(sprintf('Incorrect route. Uri: %s, route: %s', $uri, $route));
        }

        $params = [];
        foreach ($routePieces as $pieceIndex => $routePiece) {
            preg_match('/{(.*)}/', $routePiece, $paramName);
            if ($paramName && $paramName[1]) {
                $params[$paramName[1]] = $uriPieces[$pieceIndex];
            }
        }

        return $params;
    }
}
