<?php

namespace Roowix\Tests\App\Router;

use PHPUnit\Framework\TestCase;
use Roowix\App\Router\Router;

class RouterTest extends TestCase
{
    public function testParseSimpleRoute()
    {
        // arrange
        $class = 'sometestclass';
        $router = new Router(['/api/test' => $class]);

        // act
        $route = $router->parse('/api/test');

        // assert
        $this->assertEquals($class, $route->getController());
        $this->assertEmpty($route->getParams());
    }

    public function testParseParametrizedRoute()
    {
        // arrange
        $class = 'sometestclass';
        $router = new Router(['/api/test/{param}' => $class]);

        // act
        $stringRoute = $router->parse('/api/test/value');
        $intRoute = $router->parse('/api/test/123');

        // assert
        $this->assertEquals($class, $stringRoute->getController());
        $this->assertNotEmpty($stringRoute->getParams());
        $this->assertEquals('value', $stringRoute->getParams()['param']);

        $this->assertEquals($class, $intRoute->getController());
        $this->assertNotEmpty($intRoute->getParams());
        $this->assertEquals('123', $intRoute->getParams()['param']);
    }

    public function testParseLongParametrizedRoute()
    {
        // arrange
        $class = 'sometestclass';
        $router = new Router(['/api/parent/{parent_id}/child/{child_id}' => $class]);

        // act
        $route = $router->parse('/api/parent/parent_name/child/123');

        // assert
        $this->assertEquals($class, $route->getController());
        $this->assertNotEmpty($route->getParams());
        $this->assertEquals('parent_name', $route->getParams()['parent_id']);
        $this->assertEquals('123', $route->getParams()['child_id']);
    }
}
