<?php

namespace App\Modules\Controllers\Templates\Exceptions;

class NoTemplateForProjectException extends \Exception
{
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
