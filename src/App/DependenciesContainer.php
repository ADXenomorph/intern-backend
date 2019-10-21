<?php

namespace App;

use Controller\OrdersController;
use Controller\UsersController;
use DB\Connection;
use DB\PostgresEntityStorage;
use Exception;

class DependenciesContainer
{
    /** @var Config */
    private $config;
    /** @var array */
    private $container = [];

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->container = [Connection::class => new Connection($config->getConnectionString())];

        $userStorage = new PostgresEntityStorage(
            $this->container[Connection::class],
            'public.user'
        );
        $orderStorage = new PostgresEntityStorage(
            $this->container[Connection::class],
            'public.order'
        );

        $this->container[UsersController::class] = new UsersController($userStorage);
        $this->container[OrdersController::class] = new OrdersController($orderStorage);
    }

    /**
     * @param string $className
     *
     * @return mixed
     * @throws Exception
     */
    public function get(string $className)
    {
        if (!isset($this->container[$className])) {
            throw new Exception('Unknown dependency ' . $className);
        }

        return $this->container[$className];
    }
}
