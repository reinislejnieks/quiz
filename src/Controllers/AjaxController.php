<?php

namespace Quiz\Controllers;

use Quiz\Repositories\UserRepository;
class AjaxController extends BaseController
{
    public function indexAction()
    {
//        if(isset($_POST) && $_POST != null){
        if($this->post != null){
//            $post = $_POST;
//            $repo = new UserRepository();
//            $user = $repo->getById(1);
//            return json_encode('json response: '. $post['name']);
            return json_encode('reinis', JSON_UNESCAPED_UNICODE);
        }
        return $this->render('index', compact(''));
    }
    public function saveAction()
    {
        if($this->post != null){
            $data = $this->post;

            return json_encode('ok', JSON_UNESCAPED_UNICODE);
        }
        return 0;

    }
}

