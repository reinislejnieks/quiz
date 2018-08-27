<?php
namespace Quiz\Repositories\Users;
//use Quiz\Models\User;
use Quiz\Models\BaseModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\BaseDbRepository;

class UsersDbRepository extends BaseDbRepository
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
     * Returns relevant table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'users';
    }


    /**
     * @param string $name
     *
     * @return BaseModel
     */
    public function getByName(string $name)
    {
        $user = $this->one(['name' => $name]);
        if($user){
            return $user;
        }
        return $this->create(['name'=>$name]);
    }

}