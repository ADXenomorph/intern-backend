<?php

namespace Roowix\Model;

interface EntityStorageInterface
{
    public function find(array $filter): array;

    public function create(array $fields): array;

    public function update(array $fields, array $filter): array;

    public function delete(array $filter);
}
