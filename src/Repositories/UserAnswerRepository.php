<?php

namespace Quiz\Repositories;

use Quiz\Models\UserAnswerModel;

class UserAnswerRepository
{
    private $answers;

    public function saveAnswer(UserAnswerModel $answer)
    {
        $this->answers[] = $answer;
    }

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