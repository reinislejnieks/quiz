<?php

namespace Quiz\Repositories\UserAnswers;

use Quiz\Models\UserAnswerModel;
use Quiz\Repositories\BaseDbRepository;

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
        return 'userAnswers';
    }


    /**
     * @param int $userId
     * @param int $quizId
     * @param int $limit
     *
     * @return array
     */
    public function getUserAnswers(int $userId, int $quizId, int $limit): array
    {
        return $this->all([
            'userId' => $userId,
            'quizId' => $quizId
        ], $limit);
    }
}