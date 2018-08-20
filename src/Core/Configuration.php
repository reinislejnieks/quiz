<?php

namespace Quiz\Core;

class Configuration
{
    private $config;
    public function __construct()
    {
        $this->config = require SOURCE_DIR . '/config.php';
    }
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->config[$key] ?? null;
    }
}