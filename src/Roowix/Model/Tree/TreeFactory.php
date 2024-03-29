<?php

namespace Roowix\Model\Tree;

use Roowix\Model\Storage\GroupEntity;
use Roowix\Model\Storage\ProgressEntity;
use Roowix\Model\Storage\TaskEntity;
use Roowix\Model\Storage\UserEntity;

class TreeFactory
{
    /**
     * @param TaskEntity[] $tasks
     * @param ProgressEntity[] $progressList
     * @param UserEntity[] $users
     * @param GroupEntity[] $groups
     *
     * @return Tree
     */
    public function create(array $tasks, array $progressList, array $users, array $groups): Tree
    {
        $nodes = [];

        foreach ($tasks as $task) {
            $nodes[] = new TreeNode(
                $task->getTaskId(),
                $task->getName(),
                $task->getAssigneeId(),
                $this->findAssigneeName($task->getAssigneeId(), $task->getAssigneeType(), $users, $groups),
                $task->getAssigneeType(),
                $this->getCurrentProgressByTaskId($progressList, $task->getTaskId()),
                $task->getGoal(),
                $this->getTaskPercent($tasks, $progressList, $task),
                $task->getParentTaskId()
            );
        }

        return new Tree($nodes);
    }

    /**
     * @param ProgressEntity[] $progressList
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

    private function getTaskPercent(array $tasks, array $progressList, TaskEntity $task): float
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
     * @param TaskEntity $task
     * @param TaskEntity[] $tasks
     *
     * @return TaskEntity[]
     */
    private function findSubTasks(TaskEntity $task, array $tasks): array
    {
        $res = [];
        foreach ($tasks as $subtask) {
            if ($subtask->getParentTaskId() === $task->getTaskId()) {
                $res[] = $subtask;
            }
        }

        return $res;
    }

    /**
     * @param int $id
     * @param string $type
     * @param UserEntity[] $users
     * @param GroupEntity[] $groups
     *
     * @return string
     */
    private function findAssigneeName(int $id, string $type, array $users, array $groups): string
    {
        if ($type === TaskEntity::ASSIGNEE_TYPE_USER) {
            foreach ($users as $user) {
                if ($user->getUserId() === $id) {
                    return $user->getFullName();
                }
            }
        } else {
            foreach ($groups as $group) {
                if ($group->getGroupId() === $id) {
                    return $group->getName();
                }
            }
        }

        return "not found";
    }
}
