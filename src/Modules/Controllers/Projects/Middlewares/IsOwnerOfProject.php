<?php

namespace App\Modules\Controllers\Projects\Middlewares;

use App\Core\Logger;
use App\Core\Router\Middleware;
use App\Modules\Controllers\Projects\Models\Project;

class IsOwnerOfProject extends Middleware
{

    public function handle($params)
    {
        $currentUser = $_SESSION['user'];
        $projectId = $params['projectId'];
        $project = (new Project(['id' => $projectId]))->getById();
        if ($project['owner'] !== $currentUser['id']) {
            throw new \Exception("Access denied for project $projectId", 401);
        }
    }
}
