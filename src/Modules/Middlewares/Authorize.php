<?php

namespace App\Modules\Middlewares;

use App\Config\Constants;
use App\Core\Router\Middleware;
use App\Modules\Controllers\Auth\Models\User;
use App\Modules\Controllers\Auth\Models\Credential;
use App\Modules\Controllers\Auth\Utils\AuthHelpers;
use App\Modules\Controllers\Bans\UseCases\BanUseCases;
use App\Modules\Controllers\Auth\Exceptions\BannedUserException;

class Authorize extends Middleware
{
    private array $roles;
    public function __construct() {
        $this->roles = Constants::get()['users']['roles'];
    }

    public function handle($params)
    {
        // get credential of the current session
        $credential = new Credential();
        $credentialResult = $this->getCredential($credential);
        // refresh token
        $this->refreshToken($credential, $credentialResult);

        // get user from credential userId
        $user = new User(["id" => $credentialResult["userId"]]);
        $userResult = $user->getById();

        // check result
        if(!$userResult) {
            throw new \Exception("User doesnt exist", 403);
        }

        // check role
        if(!in_array($userResult["role"], $this->roles))  {
            throw new \Exception("Unauthorized", 403);
        }

        $latestBanishment = BanUseCases::getLatestBanishmentOfUser($credentialResult["userId"]);
        if(!empty($latestBanishment)) {
            ["until" => $until] = $latestBanishment;
            $today = (new \DateTime())->format('Y-m-d H:i:s');
            if($until > $today) {
                throw new BannedUserException("User banned", 403, until: $until);
            }
        }

        // bind user to session
        $_SESSION['user'] = $userResult;
    }

    private function getCredential(Credential $credential): array {
        if(!isset($_SESSION['token'])) {
            throw new \Exception("Unauthorized", 401);
        }
        $token = $_SESSION['token'];
        $result = $credential->findOne([
            ["token", "=", $token]
        ]);
        if(!$result || !boolval($result['verified'])) {
            throw new \Exception("Unauthorized", 401);
        }
        return $result;
    }

    private function refreshToken(Credential $credential, array $result) {
        $token = AuthHelpers::createToken();
        $credential->setId($result["id"]);
        $credential->setToken($token);
        $credential->save();
        AuthHelpers::setTokenSession($token);
    }

}