<?php

namespace Model\Item;

use Exception;

class Mouse implements ItemInterface
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
        return strpos(strtolower($this->getName()), 'wireless') !== false;
    }

    public function hasScreenSize(): bool
    {
        return false;
    }

    public function getScreenSize(): float
    {
        throw new Exception('Mouses dont have screens');
    }
}
