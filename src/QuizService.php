<?php

namespace Quiz;


class QuizService
{
    /** @var QuizRepository */
    private $quizes;
    /** @var UserRepository */
    private $users;
    /** @var UserAnswerRepository */
    private $userAnswers;
    /** @var int */
    private $userId;

    public function __construct(
        int $userId,
        QuizRepository $quizes,
        UserRepository $users,
        UserAnswerRepository $userAnswers
    ) {
        $this->quizes = $quizes;
        $this->users = $users;
        $this->userAnswers = $userAnswers;
        $this->userId = $userId;
    }

    public function getQuizes(): array
    {
        return $this->quizes->getList();
    }

    public function registerUser(string $name): UserModel
    {
        $user = new UserModel;
        $user->name = $name;

        return $this->users->saveOrCreate($user);
    }

    public function getQuestions(): array
    {

    }

    public function getAnswers(int $questionId)
    {

    }

    public function getUserAnwers(int $quizId)
    {

    }
}
