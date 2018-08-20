<?php

namespace Quiz\Models;

use \JsonSerializable;

abstract class BaseModel implements JsonSerializable
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /** @var int */
    public $id;

    /**  @var bool */
    public $isNew = true;

    /** @var array */
    public $attributes;

    public function jsonSerialize()
    {
        return $this->attributes;
    }
    // TODO: add this
    function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists(static::class, $key)) {
                $this->$key = $value;
            }
        }
    }
}