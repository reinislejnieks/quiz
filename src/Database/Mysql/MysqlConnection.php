<?php

namespace Quiz\Database\Mysql;

use PDO;
//use Quiz\Database\ConnectionFactory;
use Quiz\Interfaces\ConnectionInterface;

class MysqlConnection implements ConnectionInterface
{
    protected $config;

    protected $connection;

    public function __construct(MysqlConnectionConfig $config = null)
    {
        if(!$config){
//            $config = ConnectionFactory::getDriverConfig(ConnectionFactory::DRIVER_MYSQL);
            $config = new MysqlConnectionConfig();
        }
        $this->config = $config;
        $this->connect();
    }

    public function connect()
    {
        $dsn = $this->getDataSourceName();
        $this->connection = New PDO($dsn, $this->config->user, $this->config->pass);
    }

    private function getDataSourceName(): string
    {
        return $this->config->driver . ':host' . $this->config->host . ';charset=utf8;dbname' . $this->config->database;
    }

    public function select(string $table, array $conditions = [], array $select = []): string
    {
        $conditionSql = '';
        if($conditions){
            $conditionStatements = [];
            $conditionSql = 'WHERE ';
            foreach ($conditions as $attribute => $value) {
                $conditionStatements[] = implode('=', [$attribute, '?']);

            }
            $conditionSql .= implode(' AND ', $conditionStatements);
        }
        $select = $this->buildSelect($select);

        $sql = " SELECT $select FROM $table $conditionSql";

        $stm = $this->connection->prepare($sql);
        $stm->execute(array_values($conditions));
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buildSelect(array $select = []): string
    {
        if(!$select){
            return '*';
        }
        return implode(', ', $select);
    }
    public function insert(string $table, string $primaryKey, array $attributes): string
    {
        $attributes = $this->prepareAttributes($attributes, $primaryKey);
        $attributeSql = implode(', ', array_keys($attributes));
        $valueSql = implode(', ', array_fill(0, count($attributes), '?'));

        $sql = "INSERT INTO $table ($attributeSql) VALUES $valueSql";
        $stm = $this->connection->prepare($sql);

        return $stm->execute(array_values($attributes));

    }
    public function prepareAttributes( $primaryKey, array $attributes){
        if(isset($attributes[$primaryKey])){
            unset($attributes[$primaryKey]);
        }
        return $attributes;
    }
    public function update(string $table, string $primaryKey, array $attributes): string
    {
        $primaryKeySql = "$primaryKey = $attributes[$primaryKey]";


    }

    public function fetchColumns(string $table): array
    {
//        $stm = $this->connection->prepare("DESCRIBE $table");

//        return
    }
}