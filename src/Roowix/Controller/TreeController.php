<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;
use Roowix\Model\EntityStorageInterface;
use Roowix\Model\Task;
use Roowix\Model\TaskProgress;
use Roowix\Model\Tree\TreeFactory;

class TreeController extends AbstractRestController
{
    /** @var EntityStorageInterface */
    private $tasksStorage;
    /** @var EntityStorageInterface */
    private $progressStorage;
    /** @var TreeFactory */
    private $treeFactory;

    public function __construct(
        EntityStorageInterface $tasksStorage,
        EntityStorageInterface $progressStorage,
        TreeFactory $treeFactory
    ) {
        $this->tasksStorage = $tasksStorage;
        $this->progressStorage = $progressStorage;
        $this->treeFactory = $treeFactory;
    }

    protected function get(Request $request): Response
    {
        $tasks = [];
        foreach ($this->tasksStorage->find([]) as $task) {
            $tasks[] = new Task(
                $task['task_id'],
                $task['name'],
                $task['type'],
                $task['user_id'],
                $task['goal'],
                $task['parent_task_id']
            );
        }

        $progressList = [];
        foreach ($this->progressStorage->find([]) as $progress) {
            $progressList[] = new TaskProgress(
                $progress['task_progress_id'],
                $progress['task_id'],
                $progress['created_at'],
                $progress['progress']
            );
        }

        $tree = $this->treeFactory->create($tasks, $progressList);

        return $this->returnResponse($tree->toArray());
    }
}
