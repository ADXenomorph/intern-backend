<?php

namespace Roowix\Model\Tree;

class TreeNode
{
    /** @var int */
    private $taskId;
    /** @var string */
    private $name;
    /** @var int */
    private $userId;
    /** @var int */
    private $currentProgress;
    /** @var int */
    private $goal;
    /** @var float */
    private $percent;
    /** @var int|null */
    private $parentTaskId;

    public function __construct(
        int $taskId,
        string $name,
        int $userId,
        int $currentProgress,
        int $goal,
        float $percent,
        ?int $parentTaskId
    ) {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->userId = $userId;
        $this->currentProgress = $currentProgress;
        $this->goal = $goal;
        $this->percent = $percent;
        $this->parentTaskId = $parentTaskId;
    }

    public function toArray(): array
    {
        return [
            'task_id' => $this->taskId,
            'name' => $this->name,
            'user_id' => $this->userId,
            'current_progress' => $this->currentProgress,
            'goal' => $this->goal,
            'percent' => $this->percent,
            'parent_task_id' => $this->parentTaskId,
        ];
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCurrentProgress(): int
    {
        return $this->currentProgress;
    }

    public function getGoal(): int
    {
        return $this->goal;
    }

    public function getParentTaskId(): ?int
    {
        return $this->parentTaskId;
    }
}
