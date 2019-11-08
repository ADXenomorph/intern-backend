<?php

namespace Roowix\Model\Storage;

interface EntityInterface
{
    /**
     * Returns name of the primary field in the entity
     *
     * @return string
     */
    public function getPrimary(): string;

    /**
     * Returns a list of entity fields
     *
     * @return array
     */
    public function getFields(): array;
}
