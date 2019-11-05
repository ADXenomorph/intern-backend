<?php

namespace Roowix\DB;

use Exception;
use Roowix\Model\EntityStorageInterface;

class PostgresEntityStorage implements EntityStorageInterface
{
    /** @var Connection */
    private $connection;
    /** @var string */
    private $dbName;

    public function __construct(Connection $connection, string $dbName)
    {
        $this->connection = $connection;
        $this->dbName = $dbName;
    }

    public function find(array $filter): array
    {
        return $this->connection->select(
            sprintf(
                "SELECT * FROM %s %s",
                $this->dbName,
                $this->buildWhere($filter)
            )
        );
    }

    public function create(array $fields): array
    {
        if (!isset($fields['created_at'])) {
            $fields['created_at'] = date('Y-m-d H:i:s');
        }

        if (!isset($fields['updated_at'])) {
            $fields['updated_at'] = date('Y-m-d H:i:s');
        }

        $preparedFields = $this->prepareFieldValues($fields);

        $query = sprintf(
            "INSERT INTO %s (%s) VALUES (%s) RETURNING *",
            $this->dbName,
            join(', ', array_keys($preparedFields)),
            join(', ', array_values($preparedFields))
        );

        return $this->connection->query($query);
    }

    public function update(array $fields, array $filter): array
    {
        if (!isset($fields['updated_at'])) {
            $fields['updated_at'] = date('Y-m-d H:i:s');
        }

        return $this->connection->query(
            sprintf(
                "UPDATE %s SET %s %s RETURNING *",
                $this->dbName,
                join(', ', $this->buildEqualPairs($fields)),
                $this->buildWhere($filter)
            )
        );
    }

    public function delete(array $filter)
    {
        if (empty($filter)) {
            return;
        }

        $this->connection->query(
            sprintf(
                "DELETE FROM %s %s",
                $this->dbName,
                $this->buildWhere($filter)
            )
        );
    }

    private function prepareFieldValues(array $fields): array
    {
        foreach ($fields as $key => $value) {
            if (is_numeric($value)) {
                $fields[$key] = is_int($value) ? (int)$value : (float)$value;
                continue;
            }

            if (is_null($value)) {
                $fields[$key] = 'NULL';
                continue;
            }

            if (is_string($value)) {
                $fields[$key] = sprintf("'%s'", $value);
                continue;
            }

            throw new Exception("Invalid field value: " . $value);
        }

        return $fields;
    }

    private function buildEqualPairs(array $fields): array
    {
        $fields = $this->prepareFieldValues($fields);
        $equalPairs = [];

        foreach ($fields as $key => $value) {
            $equalPairs[] = $value === null
                ? sprintf("%s IS NULL", $key)
                : sprintf("%s = %s", $key, $value);
        }

        return $equalPairs;
    }

    private function buildWhere(array $filter): string
    {
        $pairs = $this->buildEqualPairs($filter);

        return count($pairs) ? "WHERE " . join(' AND ', $pairs) : '';
    }
}
