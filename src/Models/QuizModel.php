<?php

namespace Quiz\Models;

class QuizModel extends BaseModel
{

    /** @var string */
    public $name;

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'id' => $this->id
        ];
    }
}