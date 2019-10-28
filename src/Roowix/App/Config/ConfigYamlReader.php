<?php

namespace Roowix\App\Config;

use Exception;

class ConfigYamlReader
{
    public function read(string $path): Config
    {
        $yml = yaml_parse_file($path);

        $this->validate($yml);

        return new Config($yml['properties'], $yml['routes'], $yml['services']);
    }

    private function validate(array $yml)
    {
        if (!isset($yml['properties'])) {
            throw new Exception('Yaml config is missing properties section');
        }

        if (!isset($yml['routes'])) {
            throw new Exception('Yaml config is missing routes section');
        }

        if (!isset($yml['services'])) {
            throw new Exception('Yaml config is missing services section');
        }
    }
}
