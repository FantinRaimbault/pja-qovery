<?php

namespace App\Modules\Controllers\Projects\Middlewares;

use App\Core\Logger;
use App\Core\Router\Middleware;
use App\Modules\Controllers\Auth\Models\Contributor;
use App\Modules\Controllers\Projects\Models\Project;

class IsOwnerOfProjectOrHimSelf extends Middleware
{

    public function handle($params)
    {
        $currentUser = $_SESSION['user'];
        ["projectId" => $projectId, "userId" => $userId] = $params;
        if($userId !== $currentUser['id']) {
            $project = (new Project(['id' => $projectId]))->getById();
            if ($project['owner'] !== $currentUser['id']) {
                throw new \Exception("Access denied for project $projectId", 401);
            }
        }
    }
}
