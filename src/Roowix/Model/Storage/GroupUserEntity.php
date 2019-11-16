<?php

namespace Roowix\Model\Storage;

class GroupUserEntity extends AbstractEntity
{
    /** @var int */
    private $groupUserId;
    /** @var int */
    private $groupId;
    /** @var int */
    private $userId;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function getPrimary(): string
    {
        return 'group_user_id';
    }

    public function getFields(): array
    {
        return [
            'group_user_id',
            'group_id',
            'user_id',
            'created_at',
            'updated_at'
        ];
    }

    public function getGroupUserId(): int
    {
        return $this->groupUserId;
    }

    public function setGroupUserId(int $groupUserId): self
    {
        $this->groupUserId = $groupUserId;

        return $this;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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
