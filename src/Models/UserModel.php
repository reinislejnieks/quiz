<?php

namespace Quiz\Models;

class UserModel extends BaseModel
{

    /** @var string */
    public $name;

    /** @var int */
    public $lastQuestionIndex;

    public function setLastQuestionIndex($index)
    {
        $this->lastQuestionIndex = $index;
    }
    /**
     * Check to see if user is new
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->id === 0;
    }

    /**
     * Check to see if user already exists
     * @return bool
     */
    public function exists(): bool
    {
        return !$this->isNew();
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'id' => $this->id
        ];
    }
}