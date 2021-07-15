<?php

namespace App\Modules\Controllers\Projects\Middlewares;

use App\Core\Router\Middleware;
use App\Modules\Controllers\Auth\Models\Contributor;

class HasAccessToProject extends Middleware
{

    public function __construct(
        private array $roles = Contributor::ROLES
    ) {}

    public function handle($params)
    {
        $currentUser = $_SESSION['user'];
        $contributor = new Contributor();
        $projectResult = $contributor->findOne([
            ["userId", "=", $currentUser["id"]],
            ["projectId", "=", $params["projectId"]]
        ]);
        if (!$projectResult) {
            throw new \Exception('Unauthorized', 403);
        }
        if(!in_array($projectResult['role'], $this->roles)) {
            throw new \Exception('User doesnt have rights to access this project\'s resource', 403);
        }
    }

}