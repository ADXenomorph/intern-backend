<?php

namespace Roowix\DB;

use Exception;
use Roowix\Model\Storage\EntityInterface;
use Roowix\Model\Storage\EntityStorageInterface;
use Roowix\Utils\SnakeToPascal;

class PostgresEntityStorage implements EntityStorageInterface
{
    /** @var Connection */
    private $connection;
    /** @var string */
    private $dbName;
    /** @var EntityInterface */
    private $entity;

    public function __construct(
        Connection $connection,
        string $dbName,
        EntityInterface $entity
    ) {
        $this->connection = $connection;
        $this->dbName = $dbName;
        $this->entity = $entity;

        $this->validateEntity($entity);
    }

    public function find(array $filter): array
    {
        $dbData = $this->connection->select(
            sprintf(
                "SELECT * FROM %s %s",
                $this->dbName,
                $this->buildWhere($filter)
            )
        );

        $entities = [];
        foreach ($dbData as $row) {
            $entities[] = $this->mapArrayToEntity($row);
        }

        return $entities;
    }

    public function create(array $fields): EntityInterface
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

        $dbData = $this->connection->query($query);

        return $this->mapArrayToEntity($dbData);
    }

    public function update(array $fields, array $filter): EntityInterface
    {
        if (!isset($fields['updated_at'])) {
            $fields['updated_at'] = date('Y-m-d H:i:s');
        }

        $dbData = $this->connection->query(
            sprintf(
                "UPDATE %s SET %s %s RETURNING *",
                $this->dbName,
                join(', ', $this->buildEqualPairs($fields)),
                $this->buildWhere($filter)
            )
        );

        return $this->mapArrayToEntity($dbData);
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

    private function mapArrayToEntity(array $data): EntityInterface
    {
        $newEntity = clone $this->entity;
        foreach ($data as $field => $value) {
            $set = 'set' .  SnakeToPascal::convert($field);
            $newEntity->$set($value);
        }

        return $newEntity;
    }

    private function validateEntity(EntityInterface $entity)
    {
        foreach ($entity->getFields() as $field) {
            $pascalCaseField = SnakeToPascal::convert($field);
            $this->checkMethod($entity, 'get' . $pascalCaseField);
            $this->checkMethod($entity, 'set' . $pascalCaseField);
        }
    }

    private function checkMethod(EntityInterface $entity, string $method)
    {
        if (!method_exists($entity, $method)) {
            throw new Exception(
                sprintf(
                    'Entity %s is missing method %s',
                    get_class($entity),
                    $method
                )
            );
        }
    }
}
