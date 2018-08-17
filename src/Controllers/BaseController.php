<?php

namespace Quiz\Controllers;

use function Composer\Autoload\includeFile;

abstract class BaseController
{
    protected $post;

    protected $get;

    protected $action;

    public function handleCall(string $action)
    {
        $this->action = $action;
        $this->post = $_POST;
        $this->get = $_GET;

        $this->callAction($action);
    }
    protected function callAction($action)
    {
        echo static::$action();
    }

    protected function render(string $view, array $variables = []): string
    {
        $viewFile = $this->resolveViewFile($view);

        if(file_exists($viewFile)){
            extract($variables);
            ob_start();
            include "$viewFile";
            $output = ob_get_clean();

            return $output;

        }

        return 'View no found' . $viewFile;
    }
    public function resolveViewFile(string $view): string
    {
        return VIEW_DIR . "/$view.php";
    }

}