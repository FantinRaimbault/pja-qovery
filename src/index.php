<?php

namespace App;

session_start();

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;
use App\Core\Errors\ErrorHandler;
use App\Modules\Controllers\Bans\BanModule;
use App\Modules\Controllers\Auth\AuthModule;
use App\Modules\Controllers\Pages\PageModule;
use App\Modules\Controllers\Admin\AdminModule;
use App\Modules\Controllers\Auth\Exceptions\BannedUserException;
use App\Modules\Controllers\Reports\ReportModule;
use App\Modules\Controllers\Sitemap\SitemapModule;
use App\Modules\Controllers\Comments\CommentModule;
use App\Modules\Controllers\Projects\ProjectModule;
use App\Modules\Controllers\Templates\TemplateModule;
use App\Modules\Controllers\Community\CommunityModule;
use App\Modules\Controllers\Pages\UseCases\PageUseCases;
use App\Modules\Controllers\Projects\UseCases\ProjectUseCases;

require_once './vendor/autoload.php';

try {
    initializeUserWithProjects();

    $router = Router::getInstance();

    $router->use(module: AuthModule::class);

    $router->use(module: ProjectModule::class);
    $router->use(path: '/projects/:projectId', module: PageModule::class);
    $router->use(path: '/projects/:projectId', module: TemplateModule::class);

    $router->use(module: CommunityModule::class);
    $router->use(module: CommentModule::class);
    $router->use(module: ReportModule::class);
    $router->use(module: AdminModule::class);
    $router->use(module: BanModule::class);
    $router->use(module: SitemapModule::class);

    $router->get('/', callback: function ($params) use ($router) {
        $router->redirect('/login');
    });

    $router->get('/:slugProject/:slugPage', callback: function ($params) {
        $slugProject = $params['slugProject'];
        $slugPage = $params['slugPage'];
        $page = PageUseCases::getPageBySlugProjectAndSlugPage($slugProject, $slugPage);
        if (empty($page)) {
            throw new \Exception('Page not found', 404);
        }
        if (!boolval($page['isPublished'])) {
            if (!isset($_SESSION['user'])) {
                throw new \Exception('Unauthorized', 403);
            }
            if (!ProjectUseCases::isUserContributorOfProject($_SESSION['user']['email'], $page['projectId'])) {
                throw new \Exception('Unauthorized', 403);
            }
        }
        echo BinksBeatHelper::showPage($page);
    });

    $router->run();
} catch (BannedUserException $e) {
    $e->handle();
} catch (\Exception $e) {
    ErrorHandler::getResponse($e);
}

function initializeUserWithProjects()
{
    if (isset($_SESSION['user'])) {
        $projects = ProjectUseCases::getProjectsByUserId($_SESSION['user']['id']);
        $_SESSION['projects'] = $projects;
    }
}
