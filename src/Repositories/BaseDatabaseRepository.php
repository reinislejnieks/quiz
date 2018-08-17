<?php
/**
 * Created by PhpStorm.
 * User: karlis
 * Date: 15/08/2018
 * Time: 22:30
 */

namespace Quiz\Repositories;


use Quiz\Database\ConnectionFactory;
use Quiz\Interfaces\ConnectionInterface;
use Quiz\Interfaces\RepositoryInterface;
use Quiz\Models\BaseModel;
use PDO;

abstract class BaseDatabaseRepository implements RepositoryInterface
{
    /** @var ConnectionInterface */
    static $connection;

    /**
     * @param array $conditions
     * @return static[]
     */
    public function all(array $conditions = []): array
    {
        $dataArray = static::getConnection()->select(static::getTableName(), $conditions);

        $instances = [];

        foreach ($dataArray as $data) {
            $instances[] = static::init($data);
        }

        return $instances;
    }

    /**
     * @return ConnectionInterface
     */
    final protected static function getConnection(): ConnectionInterface
    {
        if (!static::$connection) {
            static::$connection = ConnectionFactory::getDriver();
        }

        return static::$connection;
    }

    /**
     * @return string
     */
    abstract public static function getTableName(): string;

    /**
     * @return string
     */
    public static function getPrimaryKey(): string
    {
        return 'id';
    }

    /**
     * @param array $attributes
     * @return BaseModel
     */
    public static function init(array $attributes)
    {
        $class = static::modelName();
        $instance = new $class;
//        $instance->setAttributes($attributes); // new
        foreach ($attributes as $key => $value) {
            if (property_exists($class, $key)) {
                $instance->$key = $value;
            }
        }
//        static::prepareAttributes($instance); // new

        return $instance;
    }

    /**
     * @param array $attributes
     * @return BaseModel
     */
    public static function initLoaded(array $attributes)
    {
        $instance = static::init($attributes);
        $instance->isNew = false;

        return $instance;
    }

    /**
     * @param int $id
     * @return static
     */
    public function getById(int $id)
    {
        return $this->one(['id' => $id]);
    }

    /**
     * @param array $conditions
     * @return BaseModel
     */
    public function one(array $conditions = [])
    {
        $data = static::getConnection()->select(static::getTableName(), $conditions)[0] ?? [];

        if (!$data) {
            return null;
        }

        return static::initLoaded($data);
    }

    /**
     * @param BaseModel $model
     * @return bool
     */
    public function save($model): bool
    {
        $connection = static::getConnection();
        if ($model->isNew) {
            return $connection->insert(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
        }

        return $connection->update(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
    }

    /**
     * @param BaseModel $model
     * @return array
     */
    public function getAttributes($model): array
    {
        if (!$model->attributes) {
            $model = $this->prepareAttributes($model);
        }

        return $model->attributes;
    }

    /**
     * @param $model
     * @return BaseModel
     */
    protected function prepareAttributes($model)
    {
        $columns = static::getConnection()->fetchColumns(static::getTableName());
        $attributes = [];

        foreach ($columns as $column) {
            if (property_exists(static::modelName(), $column)) {
                $attributes[$column] = $model->{$column};
            }
        }

        $model->attributes = $attributes;

        return $model;
    }
}