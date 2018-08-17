<?php
namespace Quiz\Repositories;
//use Quiz\Models\User;
use Quiz\Models\UserModel;

class UserDatabaseRepository extends BaseDatabaseRepository
{
    /**
     * Returns the corresponding model class name
     * @return string
     */
    public static function modelName(): string
    {
//        return User::class;
        return UserModel::class;
    }
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'users';
    }

}