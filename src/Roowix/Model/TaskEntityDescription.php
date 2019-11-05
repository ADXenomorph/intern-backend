<?php

namespace Roowix\Model;

class TaskEntityDescription implements EntityDescriptionInterface
{
    public function getFields(): array
    {
        return [
            'task_id',
            'name',
            'type',
            'user_id',
        ];
    }

    public function getIdField(): string
    {
        return 'task_id';
    }
}
