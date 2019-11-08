<?php

namespace Roowix\Utils;

class SnakeToPascal
{
    public static function convert(string $str): string
    {
        return join('', array_map('ucfirst', explode('_', $str)));
    }
}
