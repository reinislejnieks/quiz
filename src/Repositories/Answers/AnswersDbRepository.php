<?php

namespace Quiz\Repositories\Answers;

use Quiz\Models\AnswerModel;
use Quiz\Repositories\BaseDbRepository;

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


    /**
     * @param int $questionId
     *
     * @return array
     */
    public function getAnswers(int $questionId)
    {
        return $this->all(['questionId' => $questionId]);
    }
}