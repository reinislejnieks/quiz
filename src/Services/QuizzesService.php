<?php

namespace Quiz\Services;

use Quiz\Models\BaseModel;
use Quiz\Models\QuizModel;
use Quiz\Repositories\Questions\QuestionsDbRepository;
use Quiz\Repositories\Quizzes\QuizzesDbRepository;
use Quiz\Repositories\Answers\AnswersDbRepository;
use Quiz\Repositories\Results\ResultsDbRepository;
use Quiz\Repositories\UserAnswers\UserAnswersDbRepository;
use Quiz\Repositories\SessionRepository;

class QuizzesService
{
    /** @var QuizzesDbRepository */
    private $quizzes;

    /** @var QuestionsDbRepository */
    private $questions;

    /** @var AnswersDbRepository */
    private $answers;

    /** @var UserAnswersDbRepository */
    private $userAnswers;

    /** @var ResultsDbRepository */
    private $quizResults;

    /** @var SessionRepository */
    private $session;

    /** @var UsersService  */
    private $usersService;

    public function __construct(
        QuizzesDbRepository $quizzes,
        QuestionsDbRepository $questions,
        AnswersDbRepository $answers,
        UserAnswersDbRepository $userAnswers,
        ResultsDbRepository $quizResults,
        SessionRepository $session,
        UsersService $usersService
    ) {
        $this->quizzes = $quizzes;
        $this->questions = $questions;
        $this->answers = $answers;
        $this->userAnswers = $userAnswers;
        $this->quizResults = $quizResults;
        $this->session = $session;
        $this->usersService = $usersService;
    }

    /**
     * Get list of available quizzes
     * @return QuizModel[]
     */
    public function getQuizzes()
    {
        $results = $this->quizzes->all();
        return $results;
    }

    /**
     * Get list of question for a specific quiz
     *
     * @param int $userId
     * @param int $quizId
     *
     * @return mixed
     */
    public function getQuestion(int $userId, int $quizId = 1): array
    {
        $data = [];
//        $questionIndex = $this->getQuestionIndex();
        $questionIndex = $this->getLastQuestionIndex($userId);
        // lastQuestionIndex is in UserModel which extends BaseModel
        $index = ($questionIndex->lastQuestionIndex) ? $questionIndex->lastQuestionIndex : 0;

        // get questions with answers
        $allQuestions = $this->questions->getAllQuestions($quizId);
        for ($i = 0; $i < count($allQuestions); $i++) {
            $data[$i]['id'] = $allQuestions[$i]->id;
            $data[$i]['question'] = $allQuestions[$i]->question;

            // get answers for current question
            $answers = $this->answers->getAnswers($allQuestions[$i]->id);
            for ($j = 0; $j < count($answers); $j++) {
                $data[$i]['answers'][$j]['id'] = $answers[$j]->id;
                $data[$i]['answers'][$j]['answer'] = $answers[$j]->answer;
            }
        }
//        return ($index <= count($allQuestions)) ? $data[$index] : [];
        if ($index < count($allQuestions)) {
            $result = $data[$index];
            $index++;
//            $this->setQuestionIndex($index);
            $this->setLastQuestionIndex($userId, $index);
            return $result;
        };
//        $this->setQuestionIndex(0);
        $this->setLastQuestionIndex($userId, 0);
        return [];

    }

    /**
     * @param int $userId
     *
     * @return BaseModel
     */
    public function getLastQuestionIndex(int $userId): BaseModel
    {
        return $this->usersService->getLastQuestionIndex($userId);
    }

    /**
     * @param int $userId
     * @param int $index
     *
     * @return BaseModel
     */
    public function setLastQuestionIndex(int $userId, int $index): BaseModel
    {
        return $this->usersService->setLastQuestionIndex($userId, $index);
    }
    /**
     * @param array $attributes
     *
     * @return BaseModel
     */
    public function submitAnswer(array $attributes): BaseModel
    {
        return $this->userAnswers->submit($attributes);
    }


    /**
     * @param int $userId
     * @param int $quizId
     *
     * @return array|mixed|string
     */
    public function handleQuestions(int $userId, int $quizId )
    {
        $currentQuestion = $this->getQuestion($userId, $quizId);
        if (empty($currentQuestion)) {
            // This runs only if quiz is completed
            $quizScore = $this->getScore($userId, $quizId);
            $this->saveQuizResults([
                'userId' => $userId,
                'quizId' => $quizId,
                'score' => $quizScore,
                'ip' => $this->usersService->getCurrentUserIp(),
            ]);
            return 'Paldies, ka izpildīji testu! ' . $quizScore . '% tavu atbilžu bija pareizas!';
        }
        return $currentQuestion;
    }
    /**
     * Get score in the quiz in percentage round(correct answers / answer count * 100)
     *
     * @param int $userId
     * @param int $quizId
     *
     * @return int 0-100
     */
    public function getScore(int $userId, int $quizId): int
    {
        $rightAnswers = [];
        $allQuestions = $this->questions->getAllQuestions($quizId);


        foreach ($allQuestions as $question) {
            $allAnswers = $this->answers->getAnswers($question->id);
            foreach ($allAnswers as $answer) {
                if ($answer->isCorrect) {
                    $rightAnswers[] = $answer;
                }
            }
        }
        $correctUserAnswers = [];

        $questionCount = count($allQuestions);
        $allUserAnswers = $this->userAnswers->getUserAnswers($userId, $quizId, $questionCount);
//        var_dump($allUserAnswers);
        foreach ($allUserAnswers as $theAnswer) {
            foreach ($rightAnswers as $rightAnswer) {
                if ($theAnswer->answerId == $rightAnswer->id) {
                    $correctUserAnswers[] = $theAnswer;

                }
            }

        }
//        var_dump($rightAnswers);
//        var_dump($correctUserAnswers);
        return round(count($correctUserAnswers) / count($allQuestions) * 100);

    }

    /**
     * @param array $attributes
     *
     * @return BaseModel
     */
    public function saveQuizResults(array $attributes): BaseModel
    {
        return $this->quizResults->submit($attributes);
    }
}