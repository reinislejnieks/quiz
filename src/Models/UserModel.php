<?php

namespace Quiz\Models;

class UserModel extends BaseModel
{
    /** @var int */
//    public $id;

    /** @var string */
    public $created_at;

    /** @var string */
    public $name;

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
}