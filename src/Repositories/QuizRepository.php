<?php

namespace Quiz\Repositories;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;

class QuizRepository
{
    /** @var QuizModel[] */
    private $quizes = [];
    /** @var QuestionModel[] */
    private $questions = [];
    /** @var AnswerModel[] */
    private $answers = [];

    public function addQuiz(QuizModel $quiz)
    {
        $this->quizes[] = $quiz;
//        return $quiz;
    }

    public function addQuestion(QuestionModel $question)
    {
        $this->questions[] = $question;
    }

    public function addAnswers(AnswerModel $answer)
    {
        $this->answers[] = $answer;
    }

    public function getById(int $quizId): QuizModel
    {
        foreach ($this->quizes as $v) {
            if ($v->id == $quizId) {
                return $v;
            }
        }
        return new QuizModel; // Returns empty model
    }

    public function getQuestions(int $quizId): array
    {
        $questions = [];

        foreach ($this->questions as $question) {
            if ($question->quizId == $quizId) {
                $questions[] = $question;
            }
        }
    }
}