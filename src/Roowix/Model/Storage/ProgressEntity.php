<?php

namespace Roowix\Model\Storage;

class ProgressEntity extends AbstractEntity
{
    /** @var int */
    private $taskProgressId;
    /** @var int */
    private $taskId;
    /** @var int */
    private $progress;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;


    public function getPrimary(): string
    {
        return 'task_progress_id';
    }

    public function getFields(): array
    {
        return [
            'task_progress_id',
            'task_id',
            'progress',
            'created_at',
            'updated_at'
        ];
    }

    public function getTaskProgressId(): int
    {
        return $this->taskProgressId;
    }

    public function setTaskProgressId(int $taskProgressId): self
    {
        $this->taskProgressId = $taskProgressId;

        return $this;
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

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function setProgress(int $progress): self
    {
        $this->progress = $progress;

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
}
