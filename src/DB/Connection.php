<?php

namespace DB;

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
     */
    public function select(string $query)
    {
        $queryResult = pg_query($this->connection, $query);

        return pg_fetch_all($queryResult) ?? [];
    }

    public function query(string $query)
    {
        $res = pg_query($this->connection, $query);

        return pg_fetch_all($res);
    }
}
