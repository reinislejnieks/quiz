<?php

namespace Quiz\Services;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Models\QuizModel;
use Quiz\Repositories\Questions\QuestionsDbRepository;
use Quiz\Repositories\Quizzes\QuizzesDbRepository;
use Quiz\Repositories\Answers\AnswersDbRepository;

class QuizzesService
{
    /** @var QuizzesDbRepository */
    private $quizzes;

    /** @var QuestionsDbRepository */
    private $questions;

    private $answers;
    /** @var int */
    private $submitAnswerIndex = 0;

    public function __construct(
        QuizzesDbRepository $quizzes,
        QuestionsDbRepository $questions,
        AnswersDbRepository $answers
    )
    {
        $this->quizzes = $quizzes;
        $this->questions = $questions;
        $this->answers = $answers;
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
    public function getAllQuestions(int $quizId): array
    {
//        return $this->quizzes->getQuestions($quizId);
        return $this->questions->all(['quiz_id' => $quizId]);
    }

    /**
     * Get list of question for a specific quiz
     *
     * @param int $quizId
     * @param int $questionIndex
     *
     * @return QuestionModel[]
     */
    public function getQuestion(int $quizId = 1, int $questionIndex = 0)
    {
        $data = [];
        // get questions with answers
        $allQuestions = $this->getAllQuestions($quizId);
        for($i = 0; $i < count($allQuestions); $i++){
            $data[$i]['id'] =  $allQuestions[$i]->id;
            $data[$i]['question'] =  $allQuestions[$i]->question;

            // get answers for current question
            $answers = $this->getAnswers($allQuestions[$i]->id);
            for($j = 0; $j < count($answers); $j++){
                $data[$i]['answers'][$j]['id'] = $answers[$j]->id;
                $data[$i]['answers'][$j]['answer'] = $answers[$j]->answer;
            }
        }
        return $data[$questionIndex] ?? 'Done, thank you for taking the test!';

    }
    /**
     * Get list of available answers for this question
     *
     * @param int $questionId
     * @return AnswerModel[]
     */
    public function getAnswers(int $questionId): array
    {
        return $this->answers->all(['question_id' => $questionId]);
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