<?php

namespace Quiz\Repositories;

use Quiz\Models\AnswerModel;

class AnswersDbRepository extends BaseDbRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
        return AnswerModel::class;
    }
    /**
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'answers';
    }
}