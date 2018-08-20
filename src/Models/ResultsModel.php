<?php

namespace Quiz\Models;

class ResultsModel
{

    /** @var int */
    public $user_id;

    /** @var int */
    public $quiz_id;

    /** @var int */
    public $score;

    /** @var string */
    public $created_at;

    /** @var string */
    public $ip;
}