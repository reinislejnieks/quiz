<?php

namespace Quiz\Services;


use Quiz\Models\UserModel;
use Quiz\Repositories\Users\UsersDbRepository;

class UsersService
{
    /** @var UsersDbRepository */
    protected $usersDbRepository;

    public function __construct(UsersDbRepository $usersDbRepository)
    {
        $this->usersDbRepository = $usersDbRepository;
    }
    /**
     * Register a new user
     *
     * @param string $name
     * @return bool
     */
    public function registerUser(string $name): bool
    {
        /** @var User $user */
        $user = $this->usersDbRepository->create();
        $user->name = $name;
        $user->created_at = date("Y-m-d H:i:s");
        $result = $this->usersDbRepository->save($user);
        return $result;
    }
    /**
     * TODO: Check if user exists in the system (is valid)
     *
     * @param int $userId
     * @return bool
     */
//    public function isExistingUser($userId): bool
//    {
//        $model = new UserModel;
//        $user = $model->getById($userId);
//
//        return $user->exists();
//
//    }

}