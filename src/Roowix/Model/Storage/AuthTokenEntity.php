<?php

namespace Roowix\Model\Storage;

class AuthTokenEntity extends AbstractEntity
{
    /** @var int */
    private $authTokenId;
    /** @var int */
    private $authId;
    /** @var string */
    private $token;
    /** @var string */
    private $tokenExpirationDate;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;

    public function getPrimary(): string
    {
        return 'auth_token_id';
    }

    public function getFields(): array
    {
        return [
            'auth_token_id',
            'auth_id',
            'token',
            'token_expiration_date',
            'created_at',
            'updated_at'
        ];
    }

    public function getAuthTokenId(): int
    {
        return $this->authTokenId;
    }

    public function setAuthTokenId(int $authTokenId): self
    {
        $this->authTokenId = $authTokenId;

        return $this;
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

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenExpirationDate(): string
    {
        return $this->tokenExpirationDate;
    }

    public function setTokenExpirationDate(string $tokenExpirationDate): self
    {
        $this->tokenExpirationDate = $tokenExpirationDate;

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
