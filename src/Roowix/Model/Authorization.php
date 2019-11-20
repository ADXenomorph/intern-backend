<?php

namespace Roowix\Model;

use Exception;

class Authorization
{
    private const PASSWORD_SALT = '4155c877ea0aeef35784caf46e85e95aa8226d41';
    private const TOKEN_SALT = 'f7376458b49ddb191bdfe5ad050827affa53cf52';
    private const TTL = 7 * 24 * 60 * 60; // 7 days

    public function hashPassword(string $password): string
    {
        return hash_hmac('sha256', $password, self::PASSWORD_SALT);
    }

    public function encodeJwt(array $payload): string
    {
        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload = array_merge($payload, ['exp' => time() + self::TTL]);

        $header = base64_encode(json_encode($header));
        $payload = base64_encode(json_encode($payload));
        $signature = $this->sign($header, $payload);

        return implode('.', [$header, $payload, $signature]);
    }

    private function sign(string $header, string $payload): string
    {
        return hash_hmac('sha256', $header . $payload, self::TOKEN_SALT);
    }

    public function decodeJwt(string $token): array
    {
        $pieces = explode('.', $token);
        if (count($pieces) !== 3) {
            throw new Exception('Invalid JWT');
        }

        if (!hash_equals($this->sign($pieces[0], $pieces[1]), $pieces[2])) {
            throw new Exception('Invalid JWT');
        }

        $payload = json_decode(base64_decode($pieces[1]), true);

        if (!isset($payload['exp'])) {
            throw new Exception('Invalid JWT');
        }

        if (time() > $payload['exp']) {
            throw new Exception('Expired token');
        }

        return $payload;
    }

    public function getAuthHeaderPayload(string $header): ?array
    {
        try {
            $token = str_replace('Bearer ', '', $header);
            return $this->decodeJwt($token);
        } catch (Exception $ex) {
            return null;
        }
    }
}
