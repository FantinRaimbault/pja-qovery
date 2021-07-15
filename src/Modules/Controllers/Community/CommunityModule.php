<?php

namespace App\Modules\Controllers\Community;

use App\Core\View;
use App\Core\Logger;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Middlewares\IsEntityFound;
use App\Modules\Controllers\Projects\UseCases\ProjectUseCases;

class CommunityModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->get('/community', middlewares: [new Authorize()], callback: function() {
                $view = new View('community', ['main_nav', 'sidebar_home']);
                $projects = ProjectUseCases::getCommunityProjectsPopulateOwner();
                $view->assign('projects', $projects);
                $view->show();
            }),

            $this->router->get('/community/:projectId', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId'])], callback: function ($params) {
                $view = new View('community_project', ['main_nav', 'sidebar_home']);
                ["projectId" => $projectId] = $params;
                $project = ProjectUseCases::getProjectPopulateOwner($projectId);
                $comments = ProjectUseCases::getCommentsProjectPopulateUser($projectId);
                $view->assign('project', $project);
                $view->assign('comments', $comments);
                $view->show();
            }),
        ];
    }
}
