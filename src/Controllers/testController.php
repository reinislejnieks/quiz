<?php

namespace Quiz\Controllers;

use Quiz\Services\QuizzesService;
use Quiz\Services\UsersService;

class TestController extends BaseController
{
    /** @var QuizzesService */
    protected $quizzesService;

    /** @var UsersService */
    protected $usersService;

    public function __construct(QuizzesService $quizzesService, UsersService $usersService)
    {
        $this->quizzesService = $quizzesService;
        $this->usersService = $usersService;
    }

    public function indexAction(){

        $user = 'reinis';
        $this->usersService->processUser($user);
        $cUser = $this->usersService->getCurrentUserId();
        var_dump($cUser);

        var_dump($this->usersService->getUserById($cUser));
        return $this->render('test', compact('res'));
    }
}