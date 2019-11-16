<?php

namespace Roowix\Model\Storage;

class GroupEntity extends AbstractEntity
{
    /** @var int */
    private $groupId;
    /** @var string */
    private $name;
    /** @var int|null */
    private $parentGroupId;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function getPrimary(): string
    {
        return 'group_id';
    }

    public function getFields(): array
    {
        return [
            'group_id',
            'name',
            'parent_group_id',
            'created_at',
            'updated_at'
        ];
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParentGroupId(): ?int
    {
        return $this->parentGroupId;
    }

    public function setParentGroupId(?int $parentGroupId): self
    {
        $this->parentGroupId = $parentGroupId;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
