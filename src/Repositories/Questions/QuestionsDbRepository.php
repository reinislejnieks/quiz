<?php

namespace Quiz\Repositories\Questions;

use Quiz\Models\QuestionModel;
use Quiz\Repositories\BaseDbRepository;

class QuestionsDbRepository extends BaseDbRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
        return QuestionModel::class;
    }
    /**
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'questions';
    }
}