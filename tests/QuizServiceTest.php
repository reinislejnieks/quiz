<?php

namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;
use Quiz\Services\QuizService;
use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;

class QuizServiceTest extends TestCase
{
    private $userAnswerRepo;
    private $userRepo;
    private $quizRepo;

    private $service;

    private $data;


    public function setUp()
    {
        parent::setUp();

        $this->userAnswerRepo = new UserAnswerRepository;
        $this->userRepo = new UserRepository;
        $this->quizRepo = new QuizRepository;

        $this->service = new QuizService($this->quizRepo, $this->userRepo, $this->userAnswerRepo);

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
    }

    /** @test */
    public function canWeGetQuizzesFromService()
    {

        // Add a quiz model to repository
        $quiz = new QuizModel;
        $quiz->id = 1;
        $quiz->name = 'Country capitals';
        $quizModel = $this->quizRepo->addQuiz($quiz);

        // Check if service returns the quiz
        $quizzes = $this->service->getQuizzes();

        self::assertCount(1, $quizzes);
        self::assertEquals($quizModel, $quizzes[0]);
    }

    /** @test */
    public function canWeRegisterUserFromService()
    {

        $user = new UserModel(1, 'Kaspars');

        $newUser = $this->service->registerUser('Kaspars');
//        print_r($newUser);
//        self::assertCount(1, $newUser);
        self::assertEquals($user, $newUser);


    }

    /** @test */
    public function canWeCheckIfUserExistsFromService()
    {

        $user = $this->service->registerUser('Kaspars');
        $falseUser = new UserModel(0, 'Antons');

        self::assertTrue($user->exists());
        self::assertFalse($falseUser->exists());


    }

    /** @test */
    public function canWeGetAllQuizQuestionsFromService()
    {

        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepo->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepo->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswerModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;

                    $this->quizRepo->addAnswer($a);
                }
            }
        }

        $testQuizIds = 0;
        $testQuestionIds = 0;
        $questionsToTest = [];
        foreach ($this->data as $quizTitle => $questions) {
            ++$testQuizIds;
            foreach ($questions as $questionText => $answers) {
//                $questionsToTest[$questionText] = $answers;
                $question = new QuestionModel;
                $question->id = ++$testQuestionIds;
                $question->quizId = $testQuizIds;
                $question->question = $questionText;

                $questionsToTest[] = $question;
            }
        }
        // Get all questions from service
        $allQuestions = $this->service->getQuestions(1);
//        print_r($allQuestions);
        self::assertEquals($questionsToTest, $allQuestions);
        self::assertCount(3, $allQuestions);
    }

    /** @test */
    public function canWeGetListOfAvailableAnswersForQuestion()
    {
        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepo->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepo->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswerModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;

                    $this->quizRepo->addAnswer($a);
                }
            }
        }

        $allAnswers = $this->service->getAnswers(1);

        self::assertCount(4, $allAnswers);

    }

    /** @test */
    public function canWeSubmitCurrentUsersAnswer()
    {

        $this->service->submitAnswer(1, 1, 1, 1);
        $this->service->submitAnswer(1, 1, 2, 3);

        $allAnswers = $this->userAnswerRepo->getAnswers(1, 1);

        self::assertCount(2, $allAnswers);
    }

    /** @test */
    public function hasUserCompletedAllQuestionsForQuiz()
    {
        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepo->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepo->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswerModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;

                    $this->quizRepo->addAnswer($a);
                }
            }
        }

        $this->service->submitAnswer(1, 1, 1, 1);
        $this->service->submitAnswer(1, 1, 2, 3);
        $this->service->submitAnswer(1, 1, 3, 1);

        $result = $this->service->isQuizCompleted(1, 1);

        self::assertTrue($result, 'User answered to all questions');

    }
    /** @test */
    public function canWeGetTheScoreOfQuizInPercentage()
    {
        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($this->data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepo->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepo->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswerModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;

                    $this->quizRepo->addAnswer($a);
                }
            }
        }

        $this->service->submitAnswer(1, 1, 1, 1);
        $this->service->submitAnswer(1, 1, 7, 3);
        $this->service->submitAnswer(1, 1, 9, 1);

        $result = $this->service->getScore(1, 1);
        self::assertEquals(100,  $result);

    }
}