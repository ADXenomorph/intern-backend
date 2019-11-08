<?php

namespace Roowix\Tests\DB;

use Roowix\Model\Storage\EntityInterface;

class IncorrectTestEntity implements EntityInterface
{
    public function getPrimary(): string
    {
        return 'my_table_id';
    }

    public function getFields(): array
    {
        return [
            'my_table_id',
            'my_table_data'
        ];
    }
}
