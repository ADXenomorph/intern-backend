<?php

namespace Roowix\Model;

class OrderEntityDescription implements EntityDescriptionInterface
{
    public function getFields(): array
    {
        return [
            'order_id',
            'user_id',
            'item_name',
        ];
    }

    public function getIdField(): string
    {
        return 'order_id';
    }
}
