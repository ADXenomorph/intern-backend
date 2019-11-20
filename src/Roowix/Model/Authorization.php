<?php

namespace Roowix\Model;

class Authorization
{
    public const AUTH_COOKIE = 'token';

    private const PASSWORD_SALT = '4155c877ea0aeef35784caf46e85e95aa8226d41';
    private const TOKEN_SALT = 'f7376458b49ddb191bdfe5ad050827affa53cf52';

    public function hashPassword(string $password): string
    {
        return sha1($password . self::PASSWORD_SALT);
    }

    public function getToken(string $email, string $passwordHash): string
    {
        return sha1($email . $passwordHash . self::TOKEN_SALT);
    }
}
