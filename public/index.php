<?php
use Quiz\Controllers\BaseController;

define('BASE_DIR', __DIR__ . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');
define('TEMPLATE_DIR', SOURCE_DIR . '/templates');

require_once SOURCE_DIR . '/bootstrap.php';

function run()
{
    $config = app(\Quiz\Core\Configuration::class);
    $urlParams = explode('/', $_SERVER['REQUEST_URI']);
    // Remove first empty element due to explode splitting upon the first char:
    // /hello/world => [ '', 'hello', 'world' ]                             -pn
    array_shift($urlParams);
    $controllerName = ucfirst(array_shift($urlParams));
    $controllerName = $config->get('controllerNamespace') .
        ($controllerName ? $controllerName : 'Index') . 'Controller';
    $actionName = strtolower(array_shift($urlParams));
    $actionName = ($actionName ? $actionName : 'index') . 'Action';
    /** @var BaseController $controller */
    $controller = app($controllerName);
    $controller->handleCall($actionName);
}
run();



