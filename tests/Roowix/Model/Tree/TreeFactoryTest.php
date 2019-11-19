<?php

namespace Roowix\Tests\Model\Tree;

use Roowix\Model\Storage\ProgressEntity;
use Roowix\Model\Storage\TaskEntity;
use Roowix\Model\Tree\TreeFactory;
use PHPUnit\Framework\TestCase;

class TreeFactoryTest extends TestCase
{
    public function testItCanCreate()
    {
        // arrange
        $factory = new TreeFactory();
        $tasks = [
            (new TaskEntity())->setTaskId(1)->setName('task1')->setAssigneeId(1)->setGoal(10),
            (new TaskEntity())->setTaskId(2)->setName('task2')->setAssigneeId(1)->setGoal(100),
            (new TaskEntity())->setTaskId(3)->setName('task3')->setAssigneeId(1)->setGoal(123),
        ];
        $date = date('Y-m-d H:i:s', strtotime('-1 week'));
        $progress = [
            (new ProgressEntity())->setTaskId(1)->setCreatedAt($date)->setProgress(2),
            (new ProgressEntity())->setTaskId(1)->setCreatedAt($date)->setProgress(3),
            (new ProgressEntity())->setTaskId(2)->setCreatedAt($date)->setProgress(100),
            (new ProgressEntity())->setTaskId(3)->setCreatedAt($date)->setProgress(200)
        ];

        // act
        $tree = $factory->create($tasks, $progress, [], []);

        // assert
        $this->assertEquals(5, $tree->getNodeByTaskId(1)->getCurrentProgress());
        $this->assertEquals(100, $tree->getNodeByTaskId(2)->getCurrentProgress());
        $this->assertEquals(200, $tree->getNodeByTaskId(3)->getCurrentProgress());
    }
}
