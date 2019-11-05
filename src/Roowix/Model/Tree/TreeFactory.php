<?php

namespace Roowix\Model\Tree;

use Roowix\Model\Task;
use Roowix\Model\TaskProgress;

class TreeFactory
{
    /**
     * @param Task[] $tasks
     * @param TaskProgress[] $progressList
     *
     * @return Tree
     */
    public function create(array $tasks, array $progressList): Tree
    {
        $nodes = [];

        foreach ($tasks as $task) {
            $currentProgress = $this->getCurrentProgressByTaskId($progressList, $task->getTaskId());

            $nodes[] = new TreeNode(
                $task->getTaskId(),
                $task->getName(),
                $task->getUserId(),
                $currentProgress,
                $task->getGoal(),
                $task->getParentTaskId()
            );
        }

        return new Tree($nodes);
    }

    /**
     * @param TaskProgress[] $progressList
     * @param int $taskId
     *
     * @return int
     */
    private function getCurrentProgressByTaskId(array $progressList, int $taskId): int
    {
        $res = 0;
        foreach ($progressList as $progress) {
            if ($progress->getTaskId() === $taskId) {
                $res += $progress->getProgress();
            }
        }

        return $res;
    }
}
