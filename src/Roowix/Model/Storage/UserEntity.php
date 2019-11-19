<?php

namespace Roowix\Model\Storage;

class UserEntity extends AbstractEntity
{
    /** @var int */
    private $userId;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function getPrimary(): string
    {
        return 'user_id';
    }

    public function getFields(): array
    {
        return [
            'user_id',
            'first_name',
            'last_name',
            'created_at',
            'updated_at'
        ];
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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getFullName(): string
    {
        return $this->getLastName() . ' ' . $this->getFirstName();
    }
}
