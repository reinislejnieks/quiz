<?php

namespace Quiz\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        return $this->render('index');
    }
}
