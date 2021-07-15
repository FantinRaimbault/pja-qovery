<?php

namespace App\Modules\Controllers\Auth\Exceptions;

use App\Core\View;

class BannedUserException extends \Exception
{
    public function __construct($message, $code = 0, \Throwable $previous = null, $until)
    {
        parent::__construct($message, $code, $previous);
        $this->until = $until;
    }

    public function handle()
    {
        http_response_code(403);
        $view = new View('error');
        $view->assign('errorMessage', 'Vous êtes bannis jusqu\'au ' . $this->until);
        $view->show();
    }
}
