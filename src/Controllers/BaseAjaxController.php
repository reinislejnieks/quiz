<?php
namespace Quiz\Controllers;
abstract class BaseAjaxController extends BaseController
{
    public function callAction($action)
    {
        $content = static::$action();
        header('Content-Type: application/json; charset=UTF-8');
//        header("Access-Control-Allow-Origin: *");

        echo json_encode(['result' => $content], JSON_UNESCAPED_UNICODE);
    }
}