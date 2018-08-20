<?php

namespace Quiz\Repositories;

use Quiz\Models\UserAnswerModel;

class UserAnswersDbRepository extends BaseDbRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
        return UserAnswerModel::class;
    }
    /**
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'user_answers';
    }
}