<?php

namespace Roowix\DB;

use Exception;

class Connection
{
    /** @var resource */
    private $connection;

    public function __construct(string $connectionString)
    {
        $this->connection = pg_connect($connectionString);
    }

    /**
     * @param string $query
     *
     * @return array|bool
     * @throws Exception
     */
    public function select(string $query)
    {
        $queryResult = pg_query($this->connection, $query);

        $error = pg_last_error($this->connection);
        if ($error) {
            throw new Exception($error);
        }

        return pg_fetch_all($queryResult) ?: [];
    }

    /**
     * @param string $query
     *
     * @return array
     * @throws Exception
     */
    public function query(string $query)
    {
        $res = pg_query($this->connection, $query);

        $error = pg_last_error($this->connection);
        if ($error) {
            throw new Exception($error);
        }

        return pg_fetch_all($res);
    }
}
