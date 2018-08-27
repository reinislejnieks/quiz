<?php

namespace Quiz\Repositories;

use Quiz\Interfaces\ConnectionInterface;
use Quiz\Interfaces\RepositoryInterface;
use Quiz\Models\BaseModel;

abstract class BaseDbRepository implements RepositoryInterface
{
    /** @var ConnectionInterface */
    private $connection;


    /**
     * @param array $conditions
     * @param int $limit
     *
     * @return array
     */
    public function all(array $conditions = [], int $limit = 0): array
    {
        $columns = [];
        $dataArray = $this->connection->select(static::getTableName(), $conditions, $columns, $limit);

        $instances = [];

        foreach ($dataArray as $data) {
            $instances[] = $this->init($data);
        }

        return $instances;
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

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @param array $attributes
     *
     * @return BaseModel
     */
    public function init(array $attributes): BaseModel
    {
        $class = static::modelName();
        $instance = new $class;
        $instance->setAttributes($attributes);

        return $instance;
    }

    /**
     * @param array $attributes
     * @return BaseModel
     */
    public function initLoaded(array $attributes): BaseModel
    {
        $instance = $this->init($attributes);
        $instance->isNew = false;

        return $instance;
    }

    /**
     * @param int $id
     * @return BaseModel
     */
    public function getById(int $id): BaseModel
    {
        return $this->one(['id' => $id]);
    }

    /**
     * @param array $conditions
     * @param array $select
     * @return BaseModel
     */
    public function one(array $conditions = [], array $select = [])
    {
        $limit = 0;
        $data = array_first($this->connection->select(static::getTableName(), $conditions, $select, $limit));

        if (!$data) {
            return null;
        }

        return $this->initLoaded($data);
    }

    /**
     * @param BaseModel $model
     * @return BaseModel
     */
    public function save($model): BaseModel
    {
        $connection = $this->connection;

        if ($model->isNew) {
            $connection->insert(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
            $model->id = $connection->getLastInsertId();
            // TODO: is this necessary?
            $model->isNew = false;
//            $this->prepareAttributes($model);
            return $this->prepareAttributes($model);
        }

        $connection->update(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
        return $model;
    }

    /**
     * @param BaseModel $model
     * @return array
     */
    public function getAttributes($model): array
    {
        $model = $this->prepareAttributes($model);

        return $model->attributes;
    }

    /**
     * @param $model
     * @return BaseModel
     */
    protected function prepareAttributes($model)
    {
        $columns = $this->connection->fetchColumns(static::getTableName());
        $attributes = [];

        foreach ($columns as $column) {
            if (property_exists(static::modelName(), $column)) {
                $attributes[$column] = $model->{$column};
            }
        }

        $model->attributes = $attributes;

        return $model;
    }

    /**
     * @param array $attributes
     * @return BaseModel
     */
    public function create(array $attributes = [])
    {
        return $this->init($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return BaseModel
     */
    public function submit(array $attributes): BaseModel
    {
        $model = $this->create($attributes);
        return $this->save($model);
    }

    /**
     * @param BaseModel $model
     *
     * @return BaseModel
     */
    public function submitModel(BaseModel $model): BaseModel
    {
        return $this->save($model);
    }
}
