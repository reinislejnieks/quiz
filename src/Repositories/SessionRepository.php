<?php

namespace Quiz\Repositories;


class SessionRepository
{
    /**
     * @param $instance
     */
    protected static $instance;
    /**
     * @param $session_start boolean
     */
    private $session_start = false;

    public function __construct()
    {
    }

    public static function getInstance()
    {
        return (null !== self::$instance) ? self::$instance : (self::$instance = new self());
    }
    /**
     * Starts session
     */
    public function start()
    {
        if($this->session_start){
            return true;
        }
        if(!session_start()){
//            TODO: implement exceptions
//            throw new Exception('Error session start');
        }
        $this->session_start = true;
        return true;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getSessionKey($key)
    {
        $this->start();
        return array_key_exists($key, $_SESSION)? $_SESSION[$key]: null;
    }
    /**
     * @param $key string
     * @param $value string
     *
     * @return void
     */
    public function setSessionKey($key, $value)
    {
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function isSetSessionKey($key): bool
    {
        $this->start();
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function unsetSession($key)
    {
        if(array_key_exists($key, $_SESSION)){
            $value = $_SESSION[$key];
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);
            return $value;
        }

        return null;
    }
}