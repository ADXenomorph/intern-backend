<?php

namespace Model\Item;

use Exception;

class Monitor implements ItemInterface, ScreenInterface
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

    public function getScreenSize(): float
    {
        preg_match('/\d*[ ]*(?=inch)/', $this->getName(), $res);
        if ($res && $res[0]) {
            return trim($res[0]);
        }

        throw new Exception("Invalid monitor " . $this->getName());
    }
}
