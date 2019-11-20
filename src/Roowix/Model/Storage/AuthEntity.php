<?php

namespace Roowix\Model\Storage;

class AuthEntity extends AbstractEntity
{
    /** @var int */
    private $authId;
    /** @var int */
    private $userId;
    /** @var string */
    private $email;
    /** @var string */
    private $passwordHash;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function getPrimary(): string
    {
        return 'auth_id';
    }

    public function getFields(): array
    {
        return [
            'auth_id',
            'user_id',
            'email',
            'password_hash',
            'created_at',
            'updated_at'
        ];
    }

    public function getAuthId(): int
    {
        return $this->authId;
    }

    public function setAuthId(int $authId): self
    {
        $this->authId = $authId;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;

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
