<?php

namespace App\Modules\Controllers\Auth\Utils;

class AuthHelpers
{

    public static function setTokenSession($token)
    {
        $_SESSION['token'] = $token;
    }

    public static function setCsrfSession($csrf) {
        $_SESSION['csrf'] = $csrf;
    }

    public static function createToken()
    {
        $bytes = random_bytes(50);
        return bin2hex($bytes);
    }

}