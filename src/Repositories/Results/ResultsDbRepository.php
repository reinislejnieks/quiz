<?php

namespace Quiz\Repositories;

use Quiz\Models\ResultsModel;

class ResultsDbRepository extends BaseDbRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
        return ResultsModel::class;
    }
    /**
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'results';
    }
}