<?php

namespace Quiz\Interfaces;

interface RepositoryInterface
{
    public static function modelName(): string;

    public static function  getTableName(): string;
}