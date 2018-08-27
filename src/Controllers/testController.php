<?php

namespace Quiz\Controllers;

use Quiz\Repositories\UserAnswers\UserAnswersDbRepository;
use Quiz\Services\QuizzesService;
use Quiz\Services\UsersService;
use Quiz\Repositories\Users\UsersDbRepository;

class TestController extends BaseController
{
    /** @var QuizzesService */
    protected $quizzesService;

    /** @var UsersService */
    protected $usersService;

    protected $userAnswers;

    protected $users;

    public function __construct(
        QuizzesService $quizzesService,
        UsersService $usersService,
        UserAnswersDbRepository $userAnswers,
        UsersDbRepository $users
    )
    {
        $this->quizzesService = $quizzesService;
        $this->usersService = $usersService;
        $this->userAnswers = $userAnswers;
       $this->users = $users;
    }

    public function indexAction(){


//        $user = 'džons';
//        var_dump($this->usersService->processUser($user));
//        $cUser = $this->usersService->getCurrentUserId();
//        var_dump($_SESSION);
//        var_dump($cUser);
//        var_dump(typeOf('reinis'));
//        var_dump($this->usersService->getUserById($cUser));


//        $this->quizzesService->submitAnswer([
//            'userId' => 1,
//            'quizId' => 1,
//            'answerId' => 1
//        ]);
//        $results = $this->userAnswers->all([
//            'userId' => 6,
//            'quizId' => 1
//        ], 2);
//        var_dump($results);
//        var_dump($this->quizzesService->getScore(7, 1));

//        $score = $this->quizzesService->getScore(24, 1);
//        var_dump($score);
//        var_dump($_SESSION);
//        $res = $this->quizzesService->setLastQuestionIndex(17, 3);
//        $questionIndex = $this->quizzesService->getLastQuestionIndex(15);
//        var_dump($questionIndex->lastQuestionIndex);
//        $index = ($questionIndex->lastQuestionIndex) ? $questionIndex->lastQuestionIndex : 0;
//        var_dump($res);
//        var_dump($index);
//        $user = $this->users->getByName('Guna');
//        var_dump($user);
//        $newUser = $this->users->getByName('Dzintra');
//        var_dump($newUser);
//        $newUser = $this->users->getByName('Gatis');
//        var_dump($newUser);
//        $allUserAnswers = $this->userAnswers->getUserAnswers(24, 1, 2);
//        var_dump($allUserAnswers);
        $user = $this->usersService->processUser('Egons');


        return $this->render('test', compact('res'));
    }
}