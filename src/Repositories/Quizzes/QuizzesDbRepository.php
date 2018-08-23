<?php

namespace Quiz\Repositories\Quizzes;

use Quiz\Models\QuizModel;
use Quiz\Repositories\BaseDbRepository;

class QuizzesDbRepository extends BaseDbRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
        return QuizModel::class;
    }
    /**
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'quizzes';
    }
//    public function addQuiz(QuizModel $quiz): QuizModel
//    {
//         TODO
//    }

}