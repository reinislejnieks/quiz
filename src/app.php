<?php

use Quiz\Core\DependencyContainer;
$container = new DependencyContainer;
$container->provide(\Quiz\Interfaces\ConnectionInterface::class,
    \Quiz\Database\Mysql\MysqlConnection::class);
if (!function_exists('app')) {
    function app($className)
    {
        global $container;
        return $container->get($className);
    }
}