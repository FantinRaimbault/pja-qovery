<?php

namespace App\Modules\Controllers\Auth\Middlewares;

use App\Core\Router\Router;
use App\Core\Router\Middleware;
use App\Modules\Controllers\Auth\Models\Credential;

class IsAlreadyConnected extends Middleware
{
    public function handle($params)
    {
        $token = $_SESSION['token'] ?? null;
        $result = (new Credential())->findOne([
            ["token", "=", $token]
        ]);
        if($result && boolval($result['verified'])) {
            $router = Router::getInstance();
            $router->redirect('/projects');
        }
    }
}