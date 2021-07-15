<?php

namespace App\Modules\Controllers\Projects;

use App\Core\View;
use App\Core\Logger;
use App\Modules\Module;
use App\Modules\BinksBeatHelper;
use App\Modules\Middlewares\Authorize;
use App\Modules\Middlewares\IsEntityFound;
use App\Modules\Middlewares\CurrentProject;
use App\Modules\Controllers\Auth\Models\Contributor;
use App\Modules\Controllers\Projects\Models\Project;
use App\Modules\Controllers\Projects\Models\Invitation;
use App\Modules\Controllers\Projects\UseCases\ProjectUseCases;
use App\Modules\Controllers\Projects\Middlewares\IsOwnerOfProject;
use App\Modules\Controllers\Projects\Middlewares\HasAccessToProject;
use App\Modules\Controllers\Projects\Middlewares\HasAccessToInvitation;
use App\Modules\Controllers\Projects\Middlewares\IsOwnerOfProjectOrHimSelf;

class ProjectModule extends Module
{

    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->match(["get", "post"], '/projects', middlewares: [new Authorize()], callback: function () {
                $view = new View('projects', ['main_nav', 'sidebar_home']);

                $currentUser = $_SESSION['user'];
                $view->assign("user", $currentUser);

                $form = Project::createForm();
                $view->assign("form", $form);

                if ($_POST) {
                    $errors = $form->getErrors($_POST);
                    if (empty($errors)) {
                        $project = new Project(
                            array_merge(
                                $form->filterPost($_POST),
                                [
                                    "owner" => $currentUser["id"],
                                    "description" => "",
                                    "allowCommunity" => 0,
                                    "slug" => BinksBeatHelper::uniqId(),
                                    "picture" => BinksBeatHelper::getRandomColor(),
                                ]
                            )
                        );
                        $projectId = $project->save();

                        $contributor = new Contributor([
                            "projectId" => $projectId,
                            "userId" => $currentUser["id"],
                            "role" => Contributor::ROLES['admin']
                        ]);
                        $contributor->save();
                    }
                }

                $projects = ProjectUseCases::getProjectsByUserId($currentUser["id"]);
                $view->assign("projects", $projects);
                $view->show();
            }),

            $this->router->get('/projects/:projectId/informations', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(), new CurrentProject()], callback: function ($params) {
                $view = new View('project_informations', ['main_nav', 'sidebar_project']);

                $projectId = $params["projectId"];

                $project = (new Project(["id" => $projectId]))->getById();

                $view->assign("project", $project);

                $generalForm = Project::generalForm($project, "/projects/$projectId/informations/general");

                $view->assign("generalForm", $generalForm);

                $view->show();
            }),

            $this->router->post('/projects/:projectId/informations/general', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']),  new HasAccessToProject()], callback: function ($params) {
                $generalForm = Project::generalForm();
                $errors = $generalForm->getErrors($_POST);
                if (empty($errors)) {
                    $project = new Project(array_merge(
                        ["id" => $params["projectId"]],
                        $_POST
                    ));
                    $project->save();
                    $this->router->redirect(params: [
                        "success" => ["Informations mise à jour"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/projects/:projectId/informations/allowCommunity', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin'])], callback: function ($params) {
                $entityBody = file_get_contents('php://input');
                $body = json_decode($entityBody, true);

                $form = Project::communityForm();
                $errors = $form->getErrors($body);
                if (empty($errors)) {
                    $project = new Project([
                        "id" => $params['projectId'],
                        "allowCommunity" => $body['allowCommunity'],
                    ]);
                    if ($project->save()) {
                        echo json_encode(array('msg' => 'success'));
                        die;
                    }
                }
                echo json_encode(['error' => true]);
            }),

            $this->router->get('/projects/:projectId/settings', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(), new CurrentProject()], callback: function ($params) {
                $view = new View('project_settings', ['main_nav', 'sidebar_project']);
                $projectId = $params["projectId"];
                $project = (new Project(["id" => $projectId]))->getById();
                $contributors = ProjectUseCases::getContributorsByProjectId($projectId);

                // push owner beginning of array
                $index = array_search($project['owner'], array_column($contributors, 'id'));
                $owner = $contributors[$index];
                unset($contributors[$index]);
                array_unshift($contributors, $owner);

                $view->assign("currentProject", $project);
                $view->assign("contributors", $contributors);
                $view->show();
            }),

            $this->router->post('/projects/:projectId/invitations', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(['admin'])], callback: function ($params) {
                $projectId = $params['projectId'];

                $form = Invitation::createForm();
                $invitationsErrors = $form->getErrors($_POST);

                if (empty($errors)) {
                    if (ProjectUseCases::isUserContributorOfProject($_POST['email'], $projectId)) {
                        $invitationsErrors[] = "L'utilisateur fait déjà parti du projet";
                    } else {
                        $invitation = new Invitation([
                            "projectId" => $projectId,
                            "email" => $_POST['email'],
                            "role" => $_POST['role']
                        ]);
                        try {
                            $invitation->save();
                            $this->router->redirect(params: [
                                "success" => ["Invitation envoyée !"]
                            ]);
                        } catch (\Exception $e) {
                            if ($e->getCode() === 1452) {
                                $invitationsErrors[] = "Utilisateur introuvable";
                            }
                            if ($e->getCode() === 409) {
                                $invitationsErrors[] = "L'invitation a déjà été envoyé";
                            }
                        }
                    }
                }
                $this->router->redirect(params: [
                    "errors" => $invitationsErrors
                ]);
            }),

            $this->router->post('/projects/:projectId/invitations/:invitationId/status', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToInvitation()], callback: function ($params) {
                $entityBody = file_get_contents('php://input');
                $body = json_decode($entityBody, true);
                $form = Invitation::sendReponseForm();
                $errors = $form->getErrors($body);
                if (empty($errors)) {
                    [
                        'invitationId' => $invitationId,
                        'projectId' => $projectId
                    ] = $params;
                    ['id' => $userId] = $_SESSION['user'];

                    $invitation = new Invitation(['id' => $invitationId]);
                    ["role" => $invitationRole] = $invitation->getById();

                    if ($invitation->deleteById()) {
                        if ($body['response']) {
                            $contributor = new Contributor([
                                "projectId" => $projectId,
                                "userId" => $userId,
                                "role" => $invitationRole
                            ]);
                            $contributor->save();
                        }
                        echo json_encode(['msg' => 'success']);
                        die;
                    }
                }
                echo json_encode(['error' => true]);
            }),

            $this->router->post('/projects/:projectId/users/:userId/delete', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(), new IsOwnerOfProjectOrHimSelf()], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["userId" => $userId, "projectId" => $projectId] = $params;
                $contributor = new Contributor();
                if (
                    $contributor->delete([
                        ["userId", "=", $userId],
                        ["projectId", "=", $projectId]
                    ])
                ) {
                    if($_SESSION['user']['id'] === $userId) {
                        $this->router->redirect('/projects', params: [
                            "success" => ["Vous venez de quitter le projet avec succès !"]
                        ]);
                    } else {
                        $this->router->redirect(params: [
                            "success" => ["Collaborateur supprimé avec succès !"]
                        ]);
                    }
                }
                $this->router->redirect(params: [
                    "errors" => ["Une erreur est survenue lors de la suppression du Collaborateur, veuillez réessayer."]
                ]);
            }),

            $this->router->post('/projects/:projectId/users/:userId/update', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(), new IsOwnerOfProject()], callback: function ($params) {
                $form = Contributor::updateRole();
                $errors = $form->getErrors($_POST);
                if(empty($errors)) {
                    ["userId" => $userId, "projectId" => $projectId] = $params;
                    $contributor = new Contributor([
                        "role" => $_POST['role']
                    ]);
                    $contributor->update([
                        ['userId', '=', $userId],
                        ['projectId', '=', $projectId]
                    ]);
                    $this->router->redirect(params: [
                        "success" => ["Rôle du collaborateur modifié avec succès !"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/projects/:projectId/delete', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId']), new HasAccessToProject(), new IsOwnerOfProject()], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["projectId" => $projectId] = $params;
                $project = new Project();
                if ($project->delete([['id', '=', $projectId]])) {
                    $this->router->redirect('/projects');
                }
            }),
        ];
    }
}
