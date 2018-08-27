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

    private $session;

    public function __construct(
        QuizzesService $quizzesService,
        UsersService $usersService
    ) {
        $this->quizzesService = $quizzesService;
        $this->usersService = $usersService;
    }

    /**
     * @return array
     */
    public function getAllQuizzesAction(): array
    {
        $data = $this->quizzesService->getQuizzes();

        return $data;
    }

    /**
     * @return array
     */
    public function startAction(): array
    {
        $userName = $this->post->get('name');
        $quizId = $this->post->get('quizId');

        $user = $this->usersService->processUser($userName);
        return $this->quizzesService->getQuestion($user->id, $quizId);

    }

    /**
     * @return array|mixed|string
     */
    public function answerAction()
    {

        $answerId = $this->post->get('answerId');
        $quizId = $this->post->get('quizId');
        $userId = $this->usersService->getCurrentUserId();

        $this->quizzesService->submitAnswer([
            'userId' => $userId,
            'quizId' => $quizId,
            'answerId' => $answerId,
        ]);

        return $this->quizzesService->handleQuestions($userId, $quizId);

    }

}