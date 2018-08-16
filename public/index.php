<?php
require_once '../vendor/autoload.php';

//use Quiz\Repositories\BaseDatabaseRepository;
//use Quiz\Repositories\UserDatabaseRepository;
use Quiz\Repositories\UserDatabaseRepository;

//$userRepo = new UserRepository;
//$userRepo->one(['id'=>1, 'name'=>'Jānis']);

$repo = new UserDatabaseRepository;
$repo->connection();
$data = $repo->getById(1);

var_dump($data);