<?php

namespace Quiz\Models;

class AnswerModel extends BaseModel
{
    /** @var int */
    public $id;

    /** @var string */
    public $answer;

    /** @var int */
    public $questionId;

    /** @var bool */
    public $isCorrect;

}