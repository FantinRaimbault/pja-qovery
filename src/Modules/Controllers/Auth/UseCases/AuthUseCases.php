<?php

namespace App\Modules\Controllers\Auth\UseCases;

use App\Core\Database\Query;
use App\Modules\Controllers\Auth\Models\User;
use App\Modules\Controllers\Auth\Models\Credential;
use App\Modules\Controllers\Auth\Utils\AuthHelpers;

class AuthUseCases
{

    public static function connect(string $email, string $password): array
    {
        $errors = [];
        $user = new User();

        $userResult = $user->findOne([
            ["email", "=", $email],
        ]);

        if ($userResult) {
            if (!password_verify($password, $userResult['password'])) {
                $errors[] = "Mot de passe incorrect";
            } else {
                $credential = new Credential();
                $credentialResult = $credential->findOne([
                    ["userId", "=", $userResult["id"]]
                ]);
                if(!$credentialResult) {
                    throw new \Exception("User doesnt exist", 400);
                } else {
                    AuthHelpers::setTokenSession($credentialResult["token"]);
                    $csrf = AuthHelpers::createToken();
                    AuthHelpers::setCsrfSession($csrf);
                }
            }
        } else {
            $errors[] = "Identifiants incorrects";
        }
        return $errors;
    }

}