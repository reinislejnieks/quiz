<?php

class ViewNotFoundException
{
    protected $msg;

    public function __construct(string $msg, int $code = 0, Throwable $previous = null)
    {
        $this->msg .= '' . $msg;
    }
}