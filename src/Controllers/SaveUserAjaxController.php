<?php

namespace Quiz\Controllers;

use Quiz\Services\UsersService;

class SaveUserAjaxController extends BaseAjaxController
{
    /** @var UsersService */
    protected $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function saveUserAction(): bool
    {
        $name = $this->post->get('name');
        $result = $this->usersService->registerUser($name);
        return $result;
    }
}