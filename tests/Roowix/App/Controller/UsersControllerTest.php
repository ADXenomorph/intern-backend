<?php

namespace Roowix\Tests\App\Controller;

use Roowix\App\Request;
use PHPUnit\Framework\TestCase;
use Roowix\App\Response\Response;
use Roowix\Controller\UsersController;
use Roowix\Tests\Utils\InMemoryEntityStorage;

class UsersControllerTest extends TestCase
{
    public function testItCanGet()
    {
        // arrange
        $expectedResult = [['first_name' => 'Sergey']];
        $testStorage = new InMemoryEntityStorage();
        $testStorage->create($expectedResult);
        $ctrl = new UsersController($testStorage);
        $req = new Request('GET', []);

        // act
        $result = $ctrl->run($req);

        // assert
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals($expectedResult, $result->getPayload());
    }
}
