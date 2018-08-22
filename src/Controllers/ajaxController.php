<?php

namespace Quiz\Controllers;

use Quiz\Services\QuizzesService;
use Quiz\Services\UsersService;

class ajaxController extends BaseAjaxController
{
    /** @var QuizzesService */
    protected $quizzesService;

    /** @var UsersService */
    protected $usersService;

    public function __construct(QuizzesService $quizzesService, UsersService $usersService)
    {
        if (!session_id()) {
            session_start();
        }
        $this->quizzesService = $quizzesService;
        $this->usersService = $usersService;
    }

    public function getAllQuizzesAction(): array
    {
        $data = $this->quizzesService->getQuizzes();

        return $data;
    }

//    public function saveUserAction(): bool
//    {
//        $name = $this->post->get('name');
//        $result = $this->usersService->registerUser($name);
//        return $result;
//    }

    public function startAction(): array
    {
        // getting thing from request
        $userName = $this->post->get('name');
        $quizId = $this->post->get('quizId');

        // registering or returning already registered user
        $user = $this->usersService->registerUser($userName);

        // setting current question in session
        $questionIndex = 0;
        $_SESSION['questionIndex'] = $questionIndex;

        // getting and sending the first question
        return $this->quizzesService->getQuestion($quizId, $questionIndex);

    }
    public function answerAction()
    {
        $answerId = $this->post->get('answerId');
        $quizId = $this->post->get('quizId');

        $index = $_SESSION['questionIndex'] ?? 0;
        $index++;
        $_SESSION['questionIndex'] = $index;

        return $this->quizzesService->getQuestion($quizId, $index);
    }
}