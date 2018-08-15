<?php

namespace Quiz\Repositories;

use Quiz\Models\UserAnswerModel;

class UserAnswerRepository
{
    /** @var UserAnswerModel[] */
    private $answers;

    /**
     * Save user answer
     *
     * @param UserAnswerModel $answer
     * @return UserAnswerModel
     */
    public function saveAnswer(UserAnswerModel $answer): UserAnswerModel
    {
        $this->answers[] = $answer;
        return $answer;
    }

    /**
     * Get all user answers
     *
     * @param int $userId
     * @param int $quiz
     * @return array
     */
    public function getAnswers(int $userId, int $quiz): array
    {
        $matching = [];

        foreach ($this->answers as $answer) {
            if ($answer->userId == $userId && $answer->quizId == $quiz) {
                $matching[] = $answer;
            }
        }
        return $matching;
    }
}