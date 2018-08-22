<?php

namespace Quiz\Repositories;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
// TODO: refactor this class
class QuizRepository
{
    /** @var QuizModel[] */
    private $quizes = [];
    /** @var QuestionModel[] */
    private $questions = [];
    /** @var AnswerModel[] */
    private $answers = [];

    /**
     * Add new quiz
     *
     * @param QuizModel $quiz
     * @return QuizModel
     */
    public function addQuiz(QuizModel $quiz): QuizModel
    {
        $this->quizes[] = $quiz;
        return $quiz;
    }

    /**
     * Add new question
     *
     * @param QuestionModel $question
     * @return QuestionModel
     */
    public function addQuestion(QuestionModel $question): QuestionModel
    {
        $this->questions[] = $question;
        return $question;
    }

    /**
     * Add new answer
     *
     * @param AnswerModel $answer
     * @return AnswerModel
     */
    public function addAnswer(AnswerModel $answer): AnswerModel
    {
        $this->answers[] = $answer;
        return $answer;
    }

    /**
     * Get quiz by id
     *
     * @param int $quizId
     * @return QuizModel
     */
    public function getById(int $quizId): QuizModel
    {
        foreach ($this->quizes as $v) {
            if ($v->id == $quizId) {
                return $v;
            }
        }
        return new QuizModel; // Returns empty model
    }

    /**
     * @param int $quizId
     * @return array
     */
    public function getQuestions(int $quizId): array
    {
        $questions = [];

        foreach ($this->questions as $question) {
            if ($question->quizId == $quizId) {
                $questions[] = $question;
            }
        }

        return $questions;
    }

    /**
     * Get all answers of question
     *
     * @param int $questionId
     * @return array
     */
    public function getAnswers(int $questionId): array
    {
        $answers = [];

        foreach ($this->answers as $answer) {
            if ($answer->questionId == $questionId) {
                $answers[] = $answer;
            }
        }

        return $answers;
    }
    /**
     * Get answer by id
     *
     * @param int $answerId
     * @return AnswerModel
     */
    public function getAnswerById(int $answerId): AnswerModel
    {

        foreach ($this->answers as $answer) {
            if ($answer->id == $answerId) {
                return $answer;
            }else{
                return new AnswerModel;
            }
        }

    }
    /**
     * Checks if the answer is right
     *
     * @param int $questionId
     * @param int $answerId
     * @return AnswerModel
     */
//    public function isCorrectAnswer($questionId, $answerId): AnswerModel
//    {
//
//
//        foreach ($this->answers as $answer) {
//            if ($answer->questionId == $questionId && $answer->answerId == $answerId) {
//                return $answer->isCorrect;
//            }
//        }
//
//
//    }

    /**
     * Get a list of quizzes
     *
     * @return array
     */
    public function getList(): array
    {

        return $this->quizes;
    }
}