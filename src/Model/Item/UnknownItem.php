<?php

namespace Model\Item;

class UnknownItem implements ItemInterface
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
        return false;
    }

    public function getScreenSize(): float
    {
        return 0;
    }
}
