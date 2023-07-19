<?php

namespace App\Exceptions;

use Exception;

class SliderNova extends Exception
{
    public function __construct($message, $code, $severity)
    {
        parent::__construct($message, $code, $severity);
    }
}
