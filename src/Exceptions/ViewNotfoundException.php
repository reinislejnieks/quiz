<?php
/**
 * Created by PhpStorm.
 * User: rlejnieks
 * Date: 17/08/2018
 * Time: 11:05
 */

class ViewNotFoundException
{
    protected $msg;

    public function __construct(string $msg, int $code = 0, Throwable $previous = null)
    {
        $this->msg .= '' . $msg;
    }
}