<?php

namespace Quiz\Controllers;

use Quiz\Models\UserModel;
use Quiz\Repositories\Users\UsersDbRepository;

class TestController extends BaseAjaxController
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(UsersDbRepository $usersDbRepository)
    {
        if (!session_id()) {
            session_start();
        }
        $this->userRepository = $usersDbRepository;
    }

    public function saveUserAction()
    {
        $name = $this->post->get('name');
        /** @var User $user */
        $user = $this->userRepository->create();
        $user->name = $name;
        $this->userRepository->save($user);

        return $user;
    }

    public function getAllQuizzesAction()
    {
        return [
            [
                'id' => 1,
                'name' => 'Programming'
            ],
            [
                'id' => 2,
                'name' => 'Sports'
            ]
        ];
    }

//    public function indexAction()
//    {
//        return [
//            'name' => '',
//            'quizes' => [
//                [
//                    'id' => 1,
//                    'name' => 'Programming'
//                ],
//            ]
//        ];
//    }

    public function startAction()
    {
        $quizId = $this->post->get('quizId');
        $_SESSION['questionIndex'] = 0;

        return $this->getQuestion();
    }

    public function answerAction()
    {
        $answerId = $this->post->get('answerId');

        $index = isset($_SESSION['questionIndex']) ? (int)$_SESSION['questionIndex'] : 0;
        $index++;
        $_SESSION['questionIndex'] = $index;

        return $this->getQuestion($index);
    }

    public function getQuestion(int $index = 0)
    {
        $questions = [
            [
                'id' => 1,
                'question' => 'What is the most basic language Microsoft made?',
                'answers' => [
                    [
                        'id' => 1,
                        'answer' => 'Visual Basic'
                    ],
                    [
                        'id' => 2,
                        'answer' => 'DirectX'
                    ],
                    [
                        'id' => 3,
                        'answer' => 'Batch'
                    ],
                    [
                        'id' => 4,
                        'answer' => 'C++'
                    ],
                ],
            ],
            [
                'id' => 2,
                'question' => 'What does HTML stand for?',
                'answers' => [
                    [
                        'id' => 1,
                        'answer' => 'Hyper Text Markup Language'
                    ],
                    [
                        'id' => 2,
                        'answer' => 'Home Tool Markup Language'
                    ],
                    [
                        'id' => 3,
                        'answer' => 'Hyperlinks and Text Markup Language'
                    ],
                ],
            ]
        ];

        if (!isset($questions[$index])) {
            return 'Good you have done!';
        }

        return $questions[$index];
    }
}