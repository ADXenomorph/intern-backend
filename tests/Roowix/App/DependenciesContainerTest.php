<?php

namespace Roowix\Tests\App;

use Roowix\App\Config\Config;
use Roowix\App\Config\ConfigYamlReader;
use Roowix\App\DependenciesContainer;
use PHPUnit\Framework\TestCase;
use Roowix\App\Response\JsonResponseWriter;
use Roowix\DB\Connection;
use Roowix\Model\UserEntityDescription;

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
        $controller = $di->get(UserEntityDescription::class);

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