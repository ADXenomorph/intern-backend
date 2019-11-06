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
            $nodes[] = new TreeNode(
                $task->getTaskId(),
                $task->getName(),
                $task->getUserId(),
                $this->getCurrentProgressByTaskId($progressList, $task->getTaskId()),
                $task->getGoal(),
                $this->getTaskPercent($tasks, $progressList, $task),
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

    private function getTaskPercent(array $tasks, array $progressList, Task $task): float
    {
        $subtasks = $this->findSubTasks($task, $tasks);
        $percents = [];
        foreach ($subtasks as $subtask) {
            $percents[] = $this->getTaskPercent($tasks, $progressList, $subtask);
        }

        $progress = $this->getCurrentProgressByTaskId($progressList, $task->getTaskId());
        $percents[] = $progress / $task->getGoal();

        return array_sum($percents) / count($percents);
    }

    /**
     * @param Task $task
     * @param Task[] $tasks
     *
     * @return Task[]
     */
    private function findSubTasks(Task $task, array $tasks): array
    {
        $res = [];
        foreach ($tasks as $subtask) {
            if ($subtask->getParentTaskId() === $task->getTaskId()) {
                $res[] = $subtask;
            }
        }

        return $res;
    }
}
