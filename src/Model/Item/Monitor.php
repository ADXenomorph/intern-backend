<?php

namespace Model\Item;

use Exception;

class Monitor implements ItemInterface
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isWireless(): bool
    {
        return false;
    }

    public function hasScreenSize(): bool
    {
        preg_match('/\d*[ ]*(?=inch)/', $this->getName(), $res);
        return $res && $res[0];
    }

    public function getScreenSize(): float
    {
        preg_match('/\d*[ ]*(?=inch)/', $this->getName(), $res);
        if ($res && $res[0]) {
            return trim($res[0]);
        }

        throw new Exception("Invalid monitor " . $this->getName());
    }
}
