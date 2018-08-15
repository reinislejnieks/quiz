<?php

namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Repositories\QuizRepository;

class QuizTest extends TestCase
{
    /** @var QuizRepository */
    private $quizRepository;

    private $data;

//    public function setUp()
//    {
//        parent::setUp();
//
//        $this->quizRepository = new QuizRepository;
//
//        $quiz = new QuizModel;
//        $quiz->id = 2;
//        $quiz->name = 'Country capitals';
//
//        $this->quizRepository->addQuiz($quiz);
//
//        $question = new QuestionModel;
//        $question->id = 10;
//        $question->question = 'Capital of Latvia?';
//        $question->quizId = $quiz->id;
//
//        $this->quizRepository->addQuestion($question);
//
//        $answers = [
//            [1, $question->id, 'Rīga', true],
//            [2, $question->id, 'Rēzekne', false],
//            [3, $question->id, 'Ventspils', false],
//            [4, $question->id, 'Viļāni', false],
//        ];
//
//        foreach ($answers as $a) {
//            $answer = new AnswerModel;
//            $answer->id = $a[0];
//            $answer->questionId = $a[1];
//            $answer->answer = $a[2];
//            $answer->isCorrect = $a[3];
//            $this->quizRepository->addAnswers($answer);
//        }
//    }

    public function setUp()
    {
        parent::setUp();

        $this->quizRepository = new QuizRepository;

        $this->data = [
            'Country capitals' => [
                'Latvia' => [
                    'Riga' => true,
                    'Ventspils' => false,
                    'Jurmala' => false,
                    'Daugavpils' => false,
                ],
                'Lithuania' => [
                    'Kaunas' => false,
                    'Siaulia' => false,
                    'Vilnius' => true,
                    'Mazeikiai' => false,
                ],
                'Estonia' => [
                    'Talling' => true,
                    'Paarnu' => false,
                    'Tartu' => false,
                    'Valga' => false,
                ],
            ],
        ];


        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepository->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepository->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswerModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;

                    $this->quizRepository->addAnswer($a);
                }
            }
        }
    }

    /** @test */
    public function quizRetrievalById()
    {
        $quiz = $this->quizRepository->getById(1);
//        var_dump($quiz);
        self::assertEquals(1, $quiz->id);
    }

    /** @test */
    public function canWeGetAllQuestionsFromQuiz()
    {
        $questions = $this->quizRepository->getQuestions(1);

        $questionsToTest = [];
        foreach ($this->data as $quizTitle => $questions) {
            foreach ($questions as $questionText => $answers) {
                $questionsToTest[$questionText] = $answers;
            }
        }
        self::assertEquals($questionsToTest, $questions);
        self::assertCount(3, $questions);
    }

    /** @test */
    public function canWeGetAllAnswersForQuestion()
    {
        $answers = $this->quizRepository->getAnswers(1);

        self::assertCount(4, $answers);
    }

    /** @test */
    public function canWeGetAllQuizzes()
    {
        $quizzes = $this->quizRepository->getList();

        $quizzesToTest = [];
        $quizIds = 0;
        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;
            $quizzesToTest[] = $quiz;
        }

        self::assertEquals($quizzesToTest, $quizzes);
        self::assertCount(1, $quizzes);
    }

    /** @test */
    public function canWeCreateQuiz()
    {
        $repo = new QuizRepository;

        $quiz = new QuizModel;
        $quiz->id = 1;
        $quiz->name = 'Country capitals';

        $quizCreated = $repo->addQuiz($quiz);

        self::assertEquals($quiz->name, $quizCreated->name);
        self::assertInstanceOf(QuizModel::class, $quizCreated);
    }

    /** @test */
    public function canWeCreateQuestion()
    {
        $repo = new QuizRepository;

        $question = new QuestionModel;
        $question->id = 1;
        $question->quizId = 1;
        $question->question = 'Latvia';

        $questionCreated = $repo->addQuestion($question);

        self::assertEquals($question, $questionCreated);
        self::assertInstanceOf(QuestionModel::class, $questionCreated);

    }

    /** @test */
    public function canWeCreateAnswer()
    {
        $repo = new QuizRepository;

        $answer = new AnswerModel;
        $answer->id = 1;
        $answer->answer = 'Riga';
        $answer->questionId = 1;
        $answer->isCorrect = true;


        $answerCreated = $repo->addAnswer($answer);

        self::assertEquals($answer, $answerCreated);
        self::assertInstanceOf(AnswerModel::class, $answerCreated);
    }

    /** @test */
    public function canWeGetAnswerById()
    {
        $repo = new QuizRepository;

        $answer = new AnswerModel;
        $answer->id = 1;
        $answer->answer = 'Riga';
        $answer->questionId = 1;
        $answer->isCorrect = true;

        $answerCreated = $repo->addAnswer($answer);

        $newAnswer = $repo->getAnswerById(1);

        self::assertEquals($answerCreated, $newAnswer);
        self::assertInstanceOf(AnswerModel::class, $newAnswer);
    }
}
