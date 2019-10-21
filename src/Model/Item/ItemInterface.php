<?php

namespace Model\Item;

interface ItemInterface
{
    public function getName(): string;

    public function isWireless(): bool;

    public function hasScreenSize(): bool;

    public function getScreenSize(): float;
}
