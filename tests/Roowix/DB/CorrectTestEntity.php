<?php

namespace Roowix\Tests\DB;

class CorrectTestEntity extends IncorrectTestEntity
{
    /** @var int */
    private $myTableId;
    /** @var string */
    private $myTableData;

    public function getMyTableId(): int
    {
        return $this->myTableId;
    }

    public function setMyTableId(int $id): self
    {
        $this->myTableId = $id;

        return $this;
    }

    public function getMyTableData(): string
    {
        return $this->myTableData;
    }

    public function setMyTableData(string $data): self
    {
        $this->myTableData = $data;

        return $this;
    }
}
