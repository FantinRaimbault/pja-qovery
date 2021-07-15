<?php

namespace App\Core\Errors;

use App\Core\View;
use App\Core\Logger;

class ErrorHandler extends \Exception
{

    public static function getResponse(\Exception $e) {
        // Logger::dd($e); // use to debug
        $code = $e->getCode();
        http_response_code($code);
        $view = new View('error');
        $errorMessage = '';
        switch ($code) {
            case 401:
                $errorMessage = "Vous n'êtes pas connecté !";
                break;
            case 403:
                $errorMessage =  "Vous ne pouvez pas accèder à cette ressource !";
                break;
            case 404:
                $errorMessage =  "Oops cette ressource n'existe pas ...";
                break;
            default:
                $errorMessage = "Une erreur est survenue, réessayez plus tard";
                break;
        }
        $view->assign('errorMessage', $errorMessage);
        $view->show();
    }
}