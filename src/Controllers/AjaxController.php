<?php

namespace Quiz\Controllers;

use Quiz\QuizService;
use Quiz\Repositories\UserRepository;

class AjaxController extends BaseController
{
    public function indexAction()
    {
        return $this->render('index', compact(''));
    }

    public function requestAction()
    {
        if ($this->post != null) {
            $data = $this->post;
            $repo = new UserRepository;
            $allUsers = $repo->getAll();

            $service = new QuizService();
            $service->registerUser('reinis');
//            return json_encode('ok', JSON_UNESCAPED_UNICODE);
//            exit(json_encode(['status' => true], JSON_UNESCAPED_UNICODE));
            exit(json_encode($allUsers, JSON_UNESCAPED_UNICODE));
        }
        exit(json_encode(0, JSON_UNESCAPED_UNICODE));

    }
}

