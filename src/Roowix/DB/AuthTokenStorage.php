<?php

namespace Roowix\DB;

class AuthTokenStorage extends PostgresEntityStorage
{
    public function validate(string $token, int $currentTimestamp): bool
    {
        $dbData = $this->connection->select(
            sprintf(
                "SELECT * FROM %s WHERE token = '%s' AND token_expiration_date > '%s' LIMIT 1",
                $this->dbName,
                $token,
                date('Y-m-d H:i:s', $currentTimestamp)
            )
        );

        return !empty($dbData);
    }
}
