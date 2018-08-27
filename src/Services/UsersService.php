<?php

namespace Quiz\Services;

use Quiz\Models\BaseModel;
use Quiz\Repositories\SessionRepository;
use Quiz\Repositories\Users\UsersDbRepository;

class UsersService
{
    /** @var UsersDbRepository */
    protected $users;

    /** @var SessionRepository */
    protected $session;

    /** @var string */
    const SESSION_USER_ID_KEY_NAME = 'userId';

    public function __construct(UsersDbRepository $users, SessionRepository $session)
    {
        $this->users = $users;

        $this->session = $session;
    }

    /**
     * @param string $name
     *
     * @return BaseModel
     */
    public function processUser(string $name): BaseModel
    {
        $user = $this->users->getByName($name);

        if ($user->isNew) {
//            var_dump($user);
            return $this->createUser($user);
        }
        return $user;
    }

    /**
     * @param BaseModel $user
     *
     * @return BaseModel
     */
    public function createUser(BaseModel $user): BaseModel
    {
//        $user = $this->users->submit(['name' => $name]);
        $newUser = $this->users->submitModel($user);
        if (!$newUser->isNew) {
//        var_dump($newUser);
            $this->session->set(self::SESSION_USER_ID_KEY_NAME, $newUser->id);
        }
        return $newUser;
    }

    /**
     * @param $userId
     *
     * @return BaseModel
     */
    public function getUserById($userId): BaseModel
    {
        return $this->users->getById($userId);
    }

    /**
     * @return mixed
     */
    public function getCurrentUserIp(): string
    {

        $defaultIp = '127.0.0.1';

        $enVars = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($enVars as $enVar) {

            if (isset($_SERVER[$enVar])) {
                return $_SERVER[$enVar];
            }

        }
        return $defaultIp;
    }

    /**
     * @return string
     */
    public function getCurrentUserId()
    {
        return $this->session->get(self::SESSION_USER_ID_KEY_NAME);
    }

    /**
     * @param int $userId
     *
     * @return BaseModel
     */
    public function getLastQuestionIndex(int $userId): BaseModel
    {
        return $this->users->getById($userId);
    }

    /**
     * @param int $userId
     * @param int $index
     *
     * @return BaseModel
     */
    public function setLastQuestionIndex(int $userId, int $index): BaseModel
    {
        $user = $this->getUserById($userId);
//        $user->setAttributes(['lastQuestionIndex' => $index]);
        $user->setLastQuestionIndex($index);

//        $model = $this->users->create([
//            'id' => $userId,
//            'name' => $this->getUserById($userId)->name,
//            'isNew' => false,
//            'lastQuestionIndex' => $index,
//        ]);
//        return $this->users->submitModel($model);
        return $this->users->submitModel($user);
    }
}