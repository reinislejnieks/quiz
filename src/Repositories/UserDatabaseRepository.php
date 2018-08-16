<?php

namespace Quiz\Repositories;

class UserDatabaseRepository extends BaseDatabaseRepository
{
    public static function modelName(): string
    {
        return '';
    }

    public static function  getTableName(): string
    {
        return 'users';
    }


}