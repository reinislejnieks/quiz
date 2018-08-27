<?php

namespace Quiz\Models;

class ResultsModel extends BaseModel
{

    /** @var int */
    public $userId;

    /** @var int */
    public $quizId;

    /** @var int */
    public $score;

    /** @var string */
    public $ip;

    public function jsonSerialize()
    {
        return [
            'userId' => $this->userId,
            'quizId' => $this->quizId,
            'score' => $this->score,
            'createdAt' => $this->createdAt,
            'ip' => $this->ip
        ];
    }
}