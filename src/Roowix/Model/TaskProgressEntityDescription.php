<?php

namespace Roowix\Model;

class TaskProgressEntityDescription implements EntityDescriptionInterface
{
    public function getFields(): array
    {
        return [
            'task_progress_id',
            'task_id',
            'type',
            'parent_task_id',
        ];
    }

    public function getIdField(): string
    {
        return 'task_progress_id';
    }
}
