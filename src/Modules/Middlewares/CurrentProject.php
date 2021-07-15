<?php

namespace App\Modules\Middlewares;

use App\Core\Router\Middleware;
use App\Modules\Controllers\Projects\Models\Project;

/**
 * Class to set currentProject Session, it is use for all GET route 
 * include /project/:projectId to display the good name in the select in leftsidebar
 */
class CurrentProject extends Middleware
{
    public function __construct()
    {
    }

    public function handle($params)
    {
        $projectId = $params['projectId'];
        $project = new Project(['id' => $projectId]);
        $project = $project->getById();
        $_SESSION['currentProject'] = $project;
    }
}
