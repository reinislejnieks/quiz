<?php

namespace Quiz\Models;


class UserAnswerModel
{
    public $id;
    public $userId;
    public $quizId;
    public $answerId;
    public $questionId;

    public function __construct(int $id = 0, int $userId = 0, $quizId = 0, $answerId = 0, $questionId = 0)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->quizId = $quizId;
        $this->answerId = $answerId;
        $this->questionId = $questionId;
    }
}