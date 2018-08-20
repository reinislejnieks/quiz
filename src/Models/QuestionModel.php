<?php

namespace Quiz\Models;

class QuestionModel extends BaseModel
{
    /** @var int */
    public $id;

    /** @var string */
    public $question;

    /** @var int */
    public $quizId;
}