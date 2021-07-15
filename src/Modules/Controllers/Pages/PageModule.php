<?php

namespace App\Modules\Controllers\Pages;

use App\Core\View;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Middlewares\IsEntityFound;
use App\Modules\Middlewares\CurrentProject;
use App\Modules\Controllers\Pages\Models\Page;
use App\Modules\Controllers\Templates\Models\Template;
use App\Modules\Controllers\Pages\UseCases\PageUseCases;
use App\Modules\Controllers\Templates\Models\Binkstemplate;
use App\Modules\Controllers\Projects\Middlewares\HasAccessToProject;

class PageModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [

            $this->router->match(["get", "post"], '/pages', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor']), new CurrentProject()], callback: function ($params) {
                $view = new View('pages', ['main_nav', 'sidebar_project']);
                $checkIsMain = PageUseCases::checkIsMain($params['projectId']);
                $currentUser = $_SESSION['user'];
                $view->assign("user", $currentUser);

                $form = Page::createForm();
                if ($_POST) {
                    // because empty checkbox are not in $_POST
                    $_POST['isMain'] ??= "0";
                    $createPageErrors = $form->getErrors($_POST);
                    // check is there are a Main Page for this project

                    if ($checkIsMain === 1 && $_POST['isMain'] === 0 || $checkIsMain != $_POST['isMain']) {
                        if (empty($createPageErrors)) {
                            $page = new Page([
                                "name" => $_POST['name'],
                                "projectId" => $params['projectId'],
                                "slug" => preg_replace('/\s+/', '', $_POST['slug']),
                                "isMain" => intval($_POST['isMain']),
                                "isPublished" => intval($_POST['isPublished']),
                                "seoTitle" =>  "",
                                "seoDescription" =>  "",
                                "content" => "",
                                "backgroundColor" => "#87b0c7"
                            ]);
                            $page->save();
                        } else {
                            $view->assign('createPageErrors', $createPageErrors);
                        }
                    } else {
                        $view->assign('createPageErrors', ["Vous possedez déjà une page principale , veuillez décochez la page principale en question avant toute modification!"]);
                    }
                }

                $page = new Page();
                $pages = $page->find([
                    ["projectId", "=", $params['projectId']]
                ]);
                $view->assign('pages', $pages);
                $view->show();
            }),

            $this->router->post('/pages/:pageId/update', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $form = Page::updateForm();
                // because empty checkbox are not in $_POST
                $_POST['isMain'] ??= "0";
                // check is there are a Main Page for this project
                $checkIsMain = PageUseCases::checkIsMain($params['projectId']);
                $updatePageErrors = $form->getErrors($_POST);
                if ($checkIsMain === 1 && $_POST['isMain'] === 0 || $checkIsMain != $_POST['isMain']) {
                    if (empty($updatePageErrors)) {
                        $page = new Page(
                            array_merge(
                                [
                                    "id" => $params['pageId'],
                                    "projectId" => $params['projectId'],
                                ],
                                $_POST
                            )
                        );
                        $page->save();
                        $this->router->redirect(params: [
                            "success" => ["Page mise à jour avec succès !"]
                        ]);
                    } else {
                        $this->router->redirect(params: [
                            "updatePageErrors" => $updatePageErrors
                        ]);
                    }
                } else {
                    $this->router->redirect(params: [
                        "updatePageErrors" => ["Vous possedez déjà une page principale , veuillez décochez la page principale en question avant toute modification!"]
                    ]);
                }
            }),

            $this->router->post('/pages/:pageId/delete', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                $page = new Page(["id" => $params['pageId']]);
                $page->deleteById();
                $this->router->redirect(params: [
                    "success" => ["Page supprimée avec succès !"]
                ]);
            }),

            $this->router->get('/pages/:pageId/edit', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId', 'Page' => 'pageId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $_SESSION['currentPageId'] = $params['pageId'];
                $view = new View('page', ['nav']);

                $page = new Page();
                $pages = $page->find([
                    ["projectId", "=", $params['projectId']]
                ]);

                $templates = (new Template())->find([
                    ["projectId", "=", $params['projectId']]
                ]);
                $binksTemplates = (new Binkstemplate())->find();
                $currentPage = $pages[array_search($params['pageId'], array_column($pages, 'id'))];
                $view->assign('currentPage', $currentPage);
                $view->assign('currentProject', $_SESSION['currentProject']);
                $view->assign('pages', $pages);
                $view->assign('contentPage', htmlspecialchars_decode($currentPage['content']));
                $view->assign('templates', $templates);
                $view->assign('binksTemplates', $binksTemplates);
                $view->show();
            }),

            $this->router->post('/pages/:pageId/edit', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $entityBody = file_get_contents('php://input');
                $body = json_decode($entityBody, true);

                $form = Page::updateForm();
                $updatePageErrors = $form->getErrors($body);
                if (empty($updatePageErrors)) {
                    $page = new Page([
                        "id" => $params['pageId'],
                        "content" => $body['content'] ?? null,
                        "isPublished" => $body['isPublished'] ?? null,
                        "backgroundColor" => $body['backgroundColor'] ?? null,
                        "seoTitle" => $body['seoTitle'] ?? null,
                        "seoDescription" => $body['seoDescription'] ?? null
                    ]);
                    $page->checkContent();
                    if ($page->save()) {
                        echo json_encode(array('msg' => 'success'));
                        die;
                    }
                }
                echo json_encode(['error' => true]);
            }),

        ];
    }
}
