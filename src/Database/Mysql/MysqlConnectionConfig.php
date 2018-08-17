<?php

namespace Quiz\Database\Mysql;

//class MysqlConnectionConfig implements ConnectionConfigInterface
use Quiz\Interfaces\ConnectionConfigInterface;

class MysqlConnectionConfig implements ConnectionConfigInterface
{
    // get these from env
    public $driver = 'mysql';

    public $host = '127.0.0.1';

    public $port = '3306';

    public  $user = 'homestead';

    public  $password = 'secret';

    public $database = 'quiz';

}