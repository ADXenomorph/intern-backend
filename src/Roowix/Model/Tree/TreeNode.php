<?php

namespace Roowix\Model\Tree;

class TreeNode
{
    /** @var int */
    private $taskId;
    /** @var string */
    private $name;
    /** @var int */
    private $assigneeId;
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
        int $assigneeId,
        int $currentProgress,
        int $goal,
        float $percent,
        ?int $parentTaskId
    ) {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->assigneeId = $assigneeId;
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
            'assignee_id' => $this->assigneeId,
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

    public function getAssigneeId(): int
    {
        return $this->assigneeId;
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
