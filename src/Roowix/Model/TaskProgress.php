<?php

namespace Roowix\Model;

class TaskProgress
{
    /** @var int */
    private $taskProgressId;
    /** @var int */
    private $taskId;
    /** @var string */
    private $date;
    /** @var int */
    private $progress;

    public function __construct(int $taskProgressId, int $taskId, string $date, int $progress)
    {
        $this->taskProgressId = $taskProgressId;
        $this->taskId = $taskId;
        $this->date = $date;
        $this->progress = $progress;
    }

    public function getTaskProgressId(): int
    {
        return $this->taskProgressId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }
}
