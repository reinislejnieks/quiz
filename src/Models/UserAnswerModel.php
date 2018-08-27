<?php

namespace Quiz\Models;


class UserAnswerModel extends BaseModel
{
    /** @var int */
    public $userId;

    /** @var int */
    public $quizId;

    /** @var int */
    public $answerId;

}