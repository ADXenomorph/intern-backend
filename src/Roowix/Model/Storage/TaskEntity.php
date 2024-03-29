<?php

namespace Roowix\Model\Storage;

class TaskEntity extends AbstractEntity
{
    public const ASSIGNEE_TYPE_USER = 'user';
    public const ASSIGNEE_TYPE_GROUP = 'group';

    /** @var int */
    private $taskId;
    /** @var string */
    private $name;
    /** @var string|null */
    private $type;
    /** @var int */
    private $assigneeId;
    /** @var int|null */
    private $parentTaskId;
    /** @var int */
    private $goal;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;
    /** @var string */
    private $assigneeType = self::ASSIGNEE_TYPE_USER;

    public function getPrimary(): string
    {
        return 'task_id';
    }

    public function getFields(): array
    {
        return [
            'task_id',
            'name',
            'type',
            'assignee_id',
            'parent_task_id',
            'goal',
            'created_at',
            'updated_at',
            'assignee_type'
        ];
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAssigneeId(): int
    {
        return $this->assigneeId;
    }

    public function setAssigneeId(int $assigneeId): self
    {
        $this->assigneeId = $assigneeId;

        return $this;
    }

    public function getParentTaskId(): ?int
    {
        return $this->parentTaskId;
    }

    public function setParentTaskId(?int $parentTaskId): self
    {
        $this->parentTaskId = $parentTaskId;

        return $this;
    }

    public function getGoal(): int
    {
        return $this->goal;
    }

    public function setGoal(int $goal): self
    {
        $this->goal = $goal;

        return $this;
    }


    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAssigneeType(): string
    {
        return $this->assigneeType;
    }

    public function setAssigneeType(string $assigneeType): self
    {
        $this->assigneeType = $assigneeType;

        return $this;
    }
}
