<?php

namespace Roowix\Model;

class UserEntityDescription implements EntityDescriptionInterface
{
    public function getFields(): array
    {
        return [
            'user_id',
            'first_name',
            'last_name',
        ];
    }

    public function getIdField(): string
    {
        return 'user_id';
    }
}
