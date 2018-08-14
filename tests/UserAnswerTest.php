<?php

namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;

use Quiz\Models\UserAnswerModel;
use Quiz\Repositories\UserAnswerRepository;

class AnswerTest extends TestCase
{
    /** @test */
    public function canWeGetUserAnswers()
    {

        $repo = new UserAnswerRepository;

        $answer = new UserAnswerModel(1,666, 23321, 1117867);
//        $answer = new UserAnswerModel;
//        $answer->id = 1;
//        $answer->quizId = 666;
/*        $answer->questionId = 13343;*/
//        $answer->answerId = 23321;
//        $answer->userId = 1117867;
        $repo->saveAnswer($answer);

        $answer = new UserAnswerModel(222,111, 222, 1);
//        $answer = new UserAnswerModel;
//        $answer->id = 222;
//        $answer->quizId = 222;
        /*       $answer->questionId = 1;*/
//        $answer->answerId = 1;
//        $answer->userId = 111;
        $repo->saveAnswer($answer);

        $answersFound = $repo->getAnswers(111, 222);

        $answerFound = array_shift($answersFound);

        self::assertEquals($answer, $answerFound);
    }
}