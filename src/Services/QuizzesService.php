<?php

namespace Quiz\Services;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Models\QuizModel;
use Quiz\Repositories\Quizzes\QuizzesDbRepository;

class QuizzesService
{
    /** @var QuizzesDbRepository */
    private $quizzes;

    /** @var UserAnswerInMemoryRepository */
//    private $userAnswers;

    /** @var int */
    private $submitAnswerIndex = 0;

    public function __construct(
        QuizzesDbRepository $quizzes/*,
        UserAnswerInMemoryRepository $userAnswers*/
    ) {
        $this->quizzes = $quizzes;
//        $this->userAnswers = $userAnswers;
    }

    /**
     * Get list of available quizzes
     *
     * @return QuizModel[]
     */
    public function getQuizzes()
    {
        $results = $this->quizzes->all();
        return $results;
    }

    /**
     * Get list of questions for a specific quiz
     *
     * @param $quizId
     * @return QuestionModel[]
     */
    public function getQuestions(int $quizId): array
    {
        return $this->quizzes->getQuestions($quizId);
    }

    /**
     * Get list of available answers for this question
     *
     * @param int $questionId
     * @return AnswerModel[]
     */
    public function getAnswers(int $questionId): array
    {
        return $this->quizzes->getAnswers($questionId);
    }

    /**
     * Submit current users answer
     *
     * @param int $userId
     * @param int $quizId
     * @param int $questionId
     * @param int $answerId
     */
    public function submitAnswer(int $userId, int $quizId, int $questionId, int $answerId)
    {
        $model = new UserAnswerModel(++$this->submitAnswerIndex, $userId, $quizId, $questionId, $answerId);
        $this->userAnswers->saveAnswer($model);
    }

    /**
     * Check if user has answered all questions for this quiz (correct or incorrect)
     *
     * @param int $userId
     * @param int $quizId
     * @return bool
     */
    public function isQuizCompleted(int $userId, int $quizId): bool
    {
        // TODO implement
        // how much questions the quiz have in all?
        // how much answered questions?

        $allQuizQuestions = $this->quizzes->getQuestions($quizId);

        $answeredQuestions = $this->userAnswers->getAnswers($userId, $quizId);

        return count($answeredQuestions) == count($allQuizQuestions);
    }

    /**
     * Get score in the quiz in percentage round(correct answers / answer count * 100)
     *
     * @param int $userId
     * @param int $quizId
     * @return int 0-100
     */
    public function getScore(int $userId, int $quizId): int
    {
        // if is quiz completed
        // get right answers
        // get answer count


//        $correctAnswers = [];
//
//        $allQuizQuestions = $this->quizzes->getQuestions($quizId);
//        print_r($allQuizQuestions);
//        $allUserAnswers = $this->userAnswers->getAnswers($userId, $quizId);
//
//        // which answers are correct?
//        foreach ($allUserAnswers as $userAnswer) {
//
//            // TODO: needs refactoring
//            $answerToTest = $this->quizzes->getAnswerById($userAnswer->answerId);
//            if($answerToTest->isCorrect){
//                $correctAnswers[] = $answerToTest;
//            }
//
//        }
//        print_r($correctAnswers);
//        return round(count($correctAnswers) / count($allQuizQuestions) * 100);


        //
        $rightAnswers = [];

        $allQuestions = $this->getQuestions($quizId);
        foreach ($allQuestions as $question) {
            $allAnswers = $this->getAnswers($question->id);
            foreach ($allAnswers as $answer) {
                if ($answer->isCorrect) {
                    $rightAnswers[] = $answer;
                }
            }
        }

        $correctUserAnswers = [];
//        print_r($rightAnswers );
        $allUserAnswers = $this->userAnswers->getAnswers($userId, $quizId);
//        print_r($allUserAnswers );
        foreach ($allUserAnswers as $theAnswer) {
            foreach ($rightAnswers as $rightAnswer) {
                if ($theAnswer->answerId == $rightAnswer->id) {
                    $correctUserAnswers[] = $theAnswer;

                }
            }

        }

        return round(count($correctUserAnswers) / count($allQuestions) * 100);

    }
}