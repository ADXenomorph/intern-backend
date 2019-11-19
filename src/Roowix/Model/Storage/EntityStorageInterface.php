<?php

namespace Roowix\Model\Storage;

interface EntityStorageInterface
{
    /**
     * @param array $filter
     *
     * @return EntityInterface[]
     */
    public function find(array $filter): array;

    public function create(array $fields): EntityInterface;

    /**
     * @param array $fields
     * @param array $filter
     *
     * @return EntityInterface[]
     */
    public function update(array $fields, array $filter): array;

    public function delete(array $filter);
}
