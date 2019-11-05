<?php

namespace Roowix\Model;

interface EntityDescriptionInterface
{
    public function getFields(): array;

    public function getIdField(): string;
}
