<?php

namespace Quiz\Services;

use Quiz\Models\BaseModel;
use Quiz\Repositories\SessionRepository;
use Quiz\Repositories\Users\UsersDbRepository;

class UsersService
{
    /** @var UsersDbRepository */
    protected $usersDbRepository;

    /** @var SessionRepository */
    protected $sessionRepository;

    /** @var string */
    const SESSION_USER_ID_KEY_NAME = 'userId';

    public function __construct(UsersDbRepository $usersDbRepository, SessionRepository $sessionRepository)
    {
        $this->usersDbRepository = $usersDbRepository;

        $this->sessionRepository = $sessionRepository;
        $this->sessionRepository::getInstance()->start();
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function processUser(string $name)
    {
        $user = $this->usersDbRepository->getByName($name);

        if($user){
            $this->sessionRepository::getInstance()->setSessionKey(self::SESSION_USER_ID_KEY_NAME, $user->id);
            return true;
        }
        return $this->createUser($name);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function createUser(string $name): bool
    {
        $user = $this->usersDbRepository->create();
        $user->name = $name;
        $isUserSaved = $this->usersDbRepository->save($user);
        if($isUserSaved){
            $this->sessionRepository::getInstance()->setSessionKey(self::SESSION_USER_ID_KEY_NAME, $user->id);
            return $isUserSaved;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCurrentUserId(): int
    {
        return $this->sessionRepository::getInstance()->getSessionKey(self::SESSION_USER_ID_KEY_NAME);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
//    public function getUserByName(string $name)
//    {
//        return $this->usersDbRepository->getByName($name);
//    }

    /**
     * @param $userId
     *
     * @return BaseModel
     */
    public function getUserById($userId): BaseModel
    {
        return $this->usersDbRepository->getById($userId);
    }
}