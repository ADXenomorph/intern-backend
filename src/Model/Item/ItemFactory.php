<?php

namespace Model\Item;

class ItemFactory
{
    public function create(string $itemName): ItemInterface
    {
        if (strpos(strtolower($itemName), 'keyboard') !== false) {
            return new Keyboard($itemName);
        }

        if (strpos(strtolower($itemName), 'mouse') !== false) {
            return new Mouse($itemName);
        }

        if (strpos(strtolower($itemName), 'monitor') !== false) {
            return new Monitor($itemName);
        }

        return new UnknownItem($itemName);
    }
}
