<?php

namespace Quiz\Controllers;

use Quiz\Services\QuizzesService;

class GetQuizzesAjaxController extends BaseAjaxController
{
    /** @var QuizzesService */
    protected $quizzesService;

    public function __construct(QuizzesService $quizzesService)
    {
        $this->quizzesService = $quizzesService;
    }

    public function getQuizzesAction()
    {
        $data = $this->quizzesService->getQuizzes();
        return $data;
    }
}