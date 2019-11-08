<?php

namespace Roowix\Model\Storage;

use JsonSerializable;
use Roowix\Utils\SnakeToPascal;

abstract class AbstractEntity implements EntityInterface, JsonSerializable
{
    public function jsonSerialize()
    {
        $res = [];
        foreach ($this->getFields() as $field) {
            $get = 'get' . SnakeToPascal::convert($field);
            $res[$field] = $this->$get();
        }

        return $res;
    }
}
