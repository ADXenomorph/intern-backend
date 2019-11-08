<?php

namespace Roowix\Tests\DB;

use PHPUnit\Framework\TestCase;
use Roowix\DB\Connection;
use Roowix\DB\PostgresEntityStorage;

class PostgresEntityStorageTest extends TestCase
{
    public function testEntityValidationFailsWithoutGetAndSet()
    {
        // arrange
        $conn = $this->createMock(Connection::class);
        $this->expectExceptionMessageMatches('/Entity.*is missing method getMyTableId/');

        // act
        new PostgresEntityStorage($conn, 'somedb', new IncorrectTestEntity());
    }

    public function testEntityValidationSuccess()
    {
        // arrange
        $conn = $this->createMock(Connection::class);

        // act
        new PostgresEntityStorage($conn, 'somedb', new CorrectTestEntity());
    }

    public function testItCanFindEntities()
    {
        // arrange
        $conn = $this->createMock(Connection::class);
        $conn->method('select')->willReturn([['my_table_id' => 1, 'my_table_data' => 'some data']]);
        $storage = new PostgresEntityStorage($conn, 'somedb', new CorrectTestEntity());

        // act
        $res = $storage->find([]);

        // assert
        $this->assertCount(1, $res);
        $this->assertInstanceOf(CorrectTestEntity::class, $res[0]);
        /** @var CorrectTestEntity $entity */
        $entity = $res[0];
        $this->assertEquals('some data', $entity->getMyTableData());
        $this->assertEquals(1, $entity->getMyTableId());
    }
}
