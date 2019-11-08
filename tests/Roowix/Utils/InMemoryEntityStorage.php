<?php

namespace Roowix\Tests\Utils;

use Roowix\Model\Storage\EntityStorageInterface;

class InMemoryEntityStorage implements EntityStorageInterface
{
    public static $data = [];

    public function find(array $filter): array
    {
        return static::$data;
    }

    public function create(array $fields): array
    {
        static::$data = $fields;
        return $fields;
    }

    public function update(array $fields, array $filter): array
    {
        // TODO: Implement update() method.
    }

    public function delete(array $filter)
    {
        // TODO: Implement delete() method.
    }
}
