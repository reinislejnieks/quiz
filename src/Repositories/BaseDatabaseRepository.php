<?php

namespace Quiz\Repositories;
use Quiz\Interfaces\RepositoryInterface;
use Quiz\Database\Mysql\MysqlConnection;

use PDO;
abstract class BaseDatabaseRepository implements RepositoryInterface
{
    private $connection;

    public function connection()
    {
        $dbName = static::modelName();
//        return 'mysql:host=' . Config::DB_HOST . ';dbname=' .  Config::DB_NAME . ';charset=utf8';
//        $name = "mysql:host=127.0.0.1:3306;charset=utf8;dbname=" . $dbName;
//        $this->connection = new PDO($name, 'homestead', 'secret');
        $this->connection = new MysqlConnection();
    }
    public function closeConnection()
    {
        $this->connection = null;
    }
    public function getById(int $id)
    {
        $table = static::getTableName();
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stm = $this->connection->prepare($sql);
        $stm->execute([$id]);
        $this->closeConnection();

        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}