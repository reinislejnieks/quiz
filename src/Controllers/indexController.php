<?php

namespace Quiz\Controllers;

use Quiz\Repositories\Users\UsersDbRepository;
use Quiz\Services\QuizzesService;
class IndexController extends BaseController
{
    /** @var UsersDbRepository */
    protected $usersDbRepository;

    protected $quizzesService;

    public function __construct(UsersDbRepository $usersDbRepository, QuizzesService $quizzesService)
    {
        $this->usersDbRepository = $usersDbRepository;
        $this->quizzesService = $quizzesService;
    }

    public function indexAction()
    {
        $quizzes = $this->quizzesService->getQuizzes();
        $user = $this->usersDbRepository->all();
        if ($user === null) {
            // TODO 404?
        }

        return $this->render('index', compact('user', 'quizzes'));
    }
}
