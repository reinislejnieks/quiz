<?php
require_once '../vendor/autoload.php';

use QUiz\Controllers\BaseControoller;
use Quiz\Repositories\UserDatabaseRepository;

//$userRepo = new UserRepository;
//$userRepo->one(['id'=>1, 'name'=>'Jānis']);
//
//$repo = new UserDatabaseRepository;

//$data = $repo->getById(1);
//$data = $repo->getById(1);

//var_dump($data);


require '../src/bootstrap.php';

define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');

$requestUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$requestString = substr($requestUrl, strlen($baseUrl));

$urlParams = explode('/', $requestString);
$controllerName = ucfirst(array_shift($urlParams));
$controllerName = $controllerNamespace . ($controllerName ? $controllerName : 'Index') . 'Controller';
$actionName = strtolower(array_shift($urlParams));
$actionName = ($actionName ? $actionName : 'Index') . 'Action';

$controller = new $controllerName;
$controller->handleCall($actionName);

