<?php

namespace App\Modules\Controllers\Templates;

use App\Core\View;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Middlewares\IsEntityFound;
use App\Modules\Middlewares\CurrentProject;
use App\Modules\Controllers\Projects\Models\Project;
use App\Modules\Controllers\Templates\Models\Template;
use App\Modules\Controllers\Projects\Middlewares\HasAccessToProject;
use App\Modules\Controllers\Templates\Exceptions\NoTemplateForProjectException;
use App\Modules\Controllers\Templates\UseCases\TemplateUseCases;

class TemplateModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->get('/templates', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor']), new CurrentProject()], callback: function ($params) {
                $view = new View('templates', ['main_nav', 'sidebar_project']);
                $templates = (new Template())->find([
                    ["projectId", "=", $params['projectId']]
                ]);
                $view->assign('templates', $templates);
                $view->show();
            }),

            $this->router->post('/templates', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $form = Template::createTemplateForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    $template = new Template([
                        "name" => $_POST['name'],
                        "projectId" => $params['projectId'],
                        "tplBackgroundColor" => $_POST['tplBackgroundColor']
                    ]);
                    if ($template->save()) {
                        $this->router->redirect(params: [
                            "success" => ["Template créé avec succès !"]
                        ]);
                    }
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->get('/templates/:templateId', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId', 'Template' => 'templateId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $view = new View('template', ['main_nav'], false);
                ["templateId" => $templateId] = $params;
                $template = (new Template([
                    "id" => $templateId
                ]))->getById();
                $form = Template::generateTemplateForm($template);
                $view->assign('tpl', $template);
                $view->assign('projectId', $params['projectId']);
                $view->assign('templateId', $template['id']);
                $view->assign('templateSettings', (new Template($template))->getSettings());
                $view->assign('tplBackgroundColor', $template['tplBackgroundColor']);
                $view->assign('form', $form);
                $view->show();
            }),

            $this->router->post('/templates/:templateId', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId', 'Template' => 'templateId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                $form = Template::generateTemplateForm([]);
                $errors = $form->getErrors($_POST);
                ["templateId" => $templateId, "projectId" => $projectId] = $params;
                if (empty($errors)) {
                    $template = new Template(array_merge(
                        ["id" => $templateId],
                        $form->filterpost($_POST)
                    ));
                    if ($template->save()) {
                        $project = (new Project([
                            "id" => $projectId
                        ]))->getById();
                        if ($project['templateApplied'] === $templateId) {
                            TemplateUseCases::applyTemplateForProject($projectId, $templateId);
                            $this->router->redirect(params: [
                                "success" => ["Template sauvegardé et appliqué aux pages du projet !"]
                            ]);
                        } else {
                            $this->router->redirect(params: [
                                "success" => ["Template sauvegardé"]
                            ]);
                        }
                    }
                    $this->router->redirect(params: [
                        "errors" => ["Une erreur est survenue lors de la sauvegarde du template, veuillez réessayer."]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/templates/:templateId/delete', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ['id' => $currentProjectId] = $_SESSION['currentProject'];
                ["templateId" => $templateId] = $params;
                $template = new Template(["id" => $templateId]);
                if ($template->deleteById()) {
                    $this->router->redirect('/projects/' . $currentProjectId . '/templates', [
                        "success" => ["Template supprimé avec succès !"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => ["Une erreur est survenue lors de la suppression du Template, veuillez réessayer."]
                ]);
            }),

            $this->router->post('/templates/:templateId/apply', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["templateId" => $templateId, "projectId" => $projectId] = $params;

                if ($templateId === $_SESSION['currentProject']['templateApplied']) {
                    $project = new Project([
                        "id" => $projectId,
                        "templateApplied" => null
                    ]);
                    if ($project->save()) {
                        TemplateUseCases::applyTemplateForProject($projectId, $templateId, true);
                        $this->router->redirect(params: [
                            "success" => ["Template enlevé avec succès !"]
                        ]);
                    }
                } else {
                    $project = new Project([
                        "id" => $projectId,
                        "templateApplied" => $templateId
                    ]);
                    if ($project->save()) {
                        TemplateUseCases::applyTemplateForProject($projectId, $templateId);
                        $this->router->redirect(params: [
                            "success" => ["Template appliqué avec succès !"]
                        ]);
                    }
                }
                $this->router->redirect(params: [
                    "errors" => ["Une erreur est survenue lors de la suppression du Template, veuillez réessayer."]
                ]);
            }),

            $this->router->post('/templates/pages/:pageId/apply', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin', 'editor'])], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["pageId" => $pageId, "projectId" => $projectId] = $params;
                try {
                    TemplateUseCases::applyTemplateForPage($projectId, $pageId);
                } catch (NoTemplateForProjectException $e) {
                    $this->router->redirect(params: [
                        "errors" => ["Vous ne possedez pas de template parent pour votre projet !"]
                    ]);
                }
                $this->router->redirect(params: [
                    "success" => ["Template appliqué avec succès !"]
                ]);
            }),

        ];
    }
}
