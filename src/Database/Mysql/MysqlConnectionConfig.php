<?php

namespace Quiz\Database\Mysql;

//class MysqlConnectionConfig implements ConnectionConfigInterface
class MysqlConnectionConfig
{
    // get these from env
    public $driver = 'mysql';

    public $host = '127.0.0.1';

    public $port = '3306';

    public  $user = 'homestead';

    public  $pass = 'secret';

}