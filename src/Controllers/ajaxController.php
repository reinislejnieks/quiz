<?php

namespace Quiz\Controllers;

use Quiz\Models\UserModel;
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

    public function saveUserAction()
    {
        $name = $this->post->get('name');
        $this->usersService->processUser($name);
    }

    public function startAction(): array
    {
        $userName = $this->post->get('name');
        $quizId = $this->post->get('quizId');

        $this->usersService->processUser($userName);

        // has user already submitted answers to this test
        // -- if so, how much has been submitted if quiz have
        // 4 questions and user has submitted 2 they most likely
        // are the first two, so question index needs to be 2

        // 1. yes, has already answered all q
        // 2. no, has not answered to all q
        // 3. has not


        // setting current question in session
        $questionIndex = 0;
        $_SESSION['questionIndex'] = $questionIndex;

        // getting and sending the first question
        return $this->quizzesService->getQuestion($quizId, $questionIndex);

    }

    public function answerAction()
    {
        $index = $_SESSION['questionIndex'] ?? 0;
        $answerId = $this->post->get('answerId');
        $quizId = $this->post->get('quizId');

        $this->quizzesService->submitAnswer([
            'userId' => '',
            'quizId' => $quizId,
            'answerId' => $answerId,
        ]);

        $index++;
        $_SESSION['questionIndex'] = $index;

        return $this->quizzesService->getQuestion($quizId, $index);
    }
}