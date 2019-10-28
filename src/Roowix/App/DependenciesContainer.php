<?php

namespace Roowix\App;

use ReflectionClass;
use Roowix\App\Config\Config;
use Exception;

class DependenciesContainer
{
    /** @var Config */
    private $config;
    /** @var array */
    private $container = [];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $id Can be classname, DI identifier or parameter name
     *
     * @return mixed
     * @throws Exception
     */
    public function get(string $id)
    {
        if (isset($this->container[$id])) {
            return $this->container[$id];
        }

        if (strpos($id, '@') !== false) {
            $entry = $this->getEntryById($this->stripAtSymbol($id));
        } elseif (strpos($id, '%') !== false) {
            return $this->container[$id] = $this->getProperty($this->stripPercents($id));
        } elseif (class_exists($id)) {
            $entry = $this->getEntryByClass($id);
            if (empty($entry)) {
                return $this->container[$id] = $this->autowireClass($id);
            }
        } else {
            return $id;
        }

        if (!$entry) {
            throw new Exception(sprintf('Dependency %s was not configured', $id));
        }

        $args = [];
        foreach ($entry['arguments'] as $arg) {
            $args[] = $this->get($arg);
        }
        $this->container[$id] = new $entry['class'](...$args);

        if (!isset($this->container[$id])) {
            throw new Exception('Unknown dependency ' . $id);
        }

        return $this->container[$id];
    }

    public function set(string $id, $object)
    {
        $this->container[$id] = $object;
    }

    private function getProperty(string $name)
    {
        if (!isset($this->config->getProperties()[$name])) {
            throw new Exception(sprintf("Property %s is missing in config", $name));
        }

        return $this->config->getProperties()[$name];
    }

    private function getEntryById(string $id): array
    {
        foreach ($this->config->getServices() as $key => $entry) {
            if ($key === $id) {
                return $entry;
            }
        }

        throw new Exception(sprintf('DI entry %s not found', $id));
    }

    private function getEntryByClass(string $className): array
    {
        if (!class_exists($className)) {
            throw new Exception(sprintf('Class %s not found', $className));
        }

        $entries = $this->findConfigEntriesByClass($className);

        if (count($entries) > 1) {
            throw new Exception(
                sprintf(
                    'Class %s has more than 1 entry in DI and cannot be searched by class',
                    $className
                )
            );
        }

        return $entries ? reset($entries) : [];
    }

    private function findConfigEntriesByClass(string $className): array
    {
        $res = [];

        foreach ($this->config->getServices() as $entry) {
            if ($entry['class'] === $className) {
                $res[] = $entry;
            }
        }

        return $res;
    }

    private function autowireClass(string $className)
    {
        $params = $this->getParameters($className);

        if (empty($params)) {
            return new $className();
        } else {
            $args = [];
            foreach ($params as $name => $argumentClass) {
                $args[] = $this->autowireClass($argumentClass);
            }

            return new $className(...$args);
        }
    }

    private function getParameters(string $className): array
    {
        $ref = new ReflectionClass($className);
        if (!$ref->isInstantiable()) {
            return [];
        }

        $parameters = [];
        $constructor = $ref->getConstructor();
        if (!$constructor) {
            return [];
        }

        $params = $constructor->getParameters();

        foreach ($params as $param) {
            $parameters[$param->getName()] = $param->getClass();
        }

        return $parameters;
    }

    private function stripAtSymbol(string $str): string
    {
        return ltrim($str, '@');
    }

    private function stripPercents(string $str): string
    {
        return trim($str, '%');
    }
}
