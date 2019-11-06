<?php

namespace Roowix\Model;

class Task
{
    /** @var int */
    private $taskId;
    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var int */
    private $userId;
    /** @var int */
    private $goal;
    /** @var int|null */
    private $parentTaskId;

    public function __construct(int $taskId, string $name, ?string $type, int $userId, int $goal, ?int $parentTaskId)
    {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->type = $type;
        $this->userId = $userId;
        $this->goal = $goal;
        $this->parentTaskId = $parentTaskId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUserId(): int
    {
        return $this->userId;
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
