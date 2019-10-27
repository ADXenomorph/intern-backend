<?php

namespace Roowix\Tests\App\Router;

use PHPUnit\Framework\TestCase;
use Roowix\App\Router\Router;

class RouterTest extends TestCase
{
    public function testParse()
    {
        // arrange
        $router = new Router(['/api/test' => 'sometestclass']);

        // act
        $res = $router->parse('/api/test');

        // assert
    }
}
