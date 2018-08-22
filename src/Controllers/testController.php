<?php

namespace Quiz\Controllers;

use Quiz\Services\QuizzesService;
use Quiz\Services\UsersService;

class TestController extends BaseAjaxController
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

        $user = '';
        return $this->render('test', compact('user'));
    }
}