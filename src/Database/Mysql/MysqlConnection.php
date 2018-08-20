<?php

namespace Quiz\Database\Mysql;

use PDO;
use PDOStatement;
use Quiz\Core\Configuration;
use Quiz\Interfaces\ConnectionInterface;

class MysqlConnection implements ConnectionInterface
{
    private static function formatDSN(string $driver, array $config)
    {
        $dsn = "{$driver}:";

        $dsnParts = [];
        foreach ($config as $key => $value) {
            $dsnParts[] = "{$key}={$value}";
        }
        $dsn .= implode(';', $dsnParts);

        return $dsn;
    }

    /** @var PDO */
    protected $connection;

    /**
     * @param Configuration $config
     * @throws \Exception
     */
    public function __construct(Configuration $config)
    {
        $dbConfig = $config->get('db');
        if ($dbConfig === null) {
            throw new \Exception("Database connection not set up");
        }
        $this->connect($dbConfig);
    }

    private function connect(array $config)
    {
        $driver = $config['driver'];
        unset($config['driver']);
        if (array_key_exists(0, $config)) {
            $dsn = $config[0];
        } else {
            $dsn = static::formatDSN($driver, $config);
        }
        $user = $config['user'] ?? null;
        $password = $config['password'] ?? null;
        $this->connection = new PDO($dsn, $user, $password);
    }

    /**
     * @param string $table
     * @return array
     */
    public function fetchColumns(string $table): array
    {
        $statement = $this->connection->prepare("DESCRIBE $table");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param array $attributes
     * @param string $primaryKey
     * @return array
     */
    protected function prepareAttributes(array $attributes, string $primaryKey): array
    {
        if (isset($attributes[$primaryKey])) {
            unset($attributes[$primaryKey]);
        }

        return $attributes;
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    protected function prepareStatement(string $sql, array $params): PDOStatement
    {
        $statement = $this->connection->prepare($sql);

        foreach ($params as $key => $param) {
            // When using array arguments, keys are off by one -- the first
            // question mark in PDO corresponds to index 1. -pn
            if (is_int($key)) {
                $key += 1;
            }
            $statement->bindValue($key, $param);
        }

        return $statement;
    }

    /**
     * @param string $table
     * @param array $conditions
     * @param array $columns
     * @return array
     */
    public function select(string $table, array $conditions = [], array $columns = []): array
    {
        $conditionSql = '';
        if ($conditions) {
            $conditionStatements = [];
            $conditionSql = 'WHERE ';
            foreach ($conditions as $attribute => $value) {
                $conditionStatements[] = "{$attribute} = ?";
            }

            $conditionSql .= implode(' AND ', $conditionStatements);
        }

        if (!$columns) {
            $columns = '*';
        } else {
            $columns = implode(', ', $columns);
        }

        $sql = "SELECT $columns FROM $table $conditionSql";

        $statement = $this->connection->prepare($sql);
        $statement->execute(array_values($conditions));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function insert(string $table, string $primaryKey, array $attributes): bool
    {
        $attributes = $this->prepareAttributes($attributes, $primaryKey);
        $attributeSql = implode(', ', array_keys($attributes));
        $valueSql = implode(', ', array_fill(0, count($attributes), '?'));
        $sql = "INSERT INTO $table ($attributeSql) VALUES ($valueSql)";

        $statement = $this->connection->prepare($sql);
        return $statement->execute(array_values($attributes));
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function update(string $table, string $primaryKey, array $attributes): bool
    {
        $primaryKeySql = "$primaryKey = $attributes[$primaryKey]";
        $attributes = $this->prepareAttributes($attributes, $primaryKey);
        $updateStatements = [];

        foreach ($attributes as $attribute => $value) {
            $updateStatements[] = "{$attribute} = ?";
        }

        $updateSql = implode(', ', $updateStatements);
        $sql = "UPDATE $table SET $updateSql WHERE $primaryKeySql";

        $statement = $this->connection->prepare($sql);
        return $statement->execute(array_values($attributes));
    }

}
