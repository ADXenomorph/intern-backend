<?php

namespace Roowix\Tests\App;

use Roowix\App\Config\Config;
use Roowix\App\Config\ConfigYamlReader;
use Roowix\App\DependenciesContainer;
use PHPUnit\Framework\TestCase;
use Roowix\App\Response\JsonResponseWriter;
use Roowix\Controller\UsersController;
use Roowix\DB\Connection;
use Roowix\DB\PostgresEntityStorage;
use Roowix\Model\UserEntityDescription;
use Roowix\Tests\DB\CorrectTestEntity;

class DependenciesContainerTest extends TestCase
{
    public function testItCanFindExistingClass()
    {
        // arrange
        $cfg = (new ConfigYamlReader())->read(__DIR__ . '/../../../config/config.yml');
        $di = new DependenciesContainer($cfg);
        $mock = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $di->set('@postgres.connection', $mock);

        // act
        $controller = $di->get(UsersController::class);

        // assert
        $this->assertNotEmpty($controller);
    }

    public function testItCanAutowire()
    {
        // arrange
        $di = new DependenciesContainer(new Config([], [], []));

        // act
        $obj = $di->get(JsonResponseWriter::class);

        // assert
        $this->assertNotEmpty($obj);
    }
}
