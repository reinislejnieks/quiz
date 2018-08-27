<?php

namespace Quiz\Repositories;


class SessionRepository
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
//            session_id();
//            session_start(['read_and_close' => true]);
            session_start();

        }
    }


    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null ;
    }


    /**
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
         $_SESSION[$key] = $value;
//        session_write_close();
        return isset($_SESSION[$key]);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function isSet($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $_SESSION;
    }


    /**
     * @param $key
     *
     * @return bool
     */
    public function delete($key): bool
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
        return !$this->isSet($key);
    }


    /**
     * Delete session
     */
    public function destroy()
    {
        session_unset();
        session_destroy();
    }
}