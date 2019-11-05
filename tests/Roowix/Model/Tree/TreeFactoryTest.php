<?php

namespace Roowix\Tests\Model\Tree;

use Roowix\Model\Task;
use Roowix\Model\TaskProgress;
use Roowix\Model\Tree\TreeFactory;
use PHPUnit\Framework\TestCase;

class TreeFactoryTest extends TestCase
{
    public function testItCanCreate()
    {
        // arrange
        $factory = new TreeFactory();
        $tasks = [
            new Task(1, 'task1', '', 1, 10, null),
            new Task(2, 'task2', '', 1, 100, 1),
            new Task(3, 'task3', '', 1, 123, 1),
        ];
        $progress = [
            new TaskProgress(0, 1, date('Y-m-d H:i:s', strtotime('-1 week')), 2),
            new TaskProgress(0, 1, date('Y-m-d H:i:s', strtotime('-1 week')), 3),

            new TaskProgress(0, 2, date('Y-m-d H:i:s', strtotime('-1 week')), 100),

            new TaskProgress(0, 3, date('Y-m-d H:i:s', strtotime('-1 week')), 200),
        ];

        // act
        $tree = $factory->create($tasks, $progress);

        // assert
        $this->assertEquals(5, $tree->getNodeByTaskId(1)->getCurrentProgress());
        $this->assertEquals(100, $tree->getNodeByTaskId(2)->getCurrentProgress());
        $this->assertEquals(200, $tree->getNodeByTaskId(3)->getCurrentProgress());
    }
}
