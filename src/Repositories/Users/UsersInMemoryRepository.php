<?php

namespace Quiz\Repositories\Users;

use Quiz\Models\UserModel;

class UsersInMemoryRepository
{
    /** @var UserModel[] */
    private $users = [];

    private $idCounter = 0;

    public function getById(int $userId): UserModel
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }

        return new UserModel; // Returns empty model
    }

    public function saveOrCreate(UserModel $user): UserModel
    {
        $existingUser = $this->getById($user->id);

        if ($existingUser->isNew()) {
            $this->idCounter += 1;
            $existingUser->id = $this->idCounter;
        }
        $existingUser->name = $user->name;

        $this->users[$existingUser->id] = $existingUser;

        return $existingUser;
    }

    public function getAll(): array
    {
        return $this->users;
    }
}