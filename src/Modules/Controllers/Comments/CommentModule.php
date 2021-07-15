<?php

namespace App\Modules\Controllers\Comments;

use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Controllers\Comments\Models\Comment;
use App\Modules\Controllers\Comments\Middlewares\IsOwnerOfComment;
use App\Modules\Middlewares\IsEntityFound;

class CommentModule extends Module
{

    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->post('/comments/projects/:projectId', middlewares: [new Authorize(), new IsEntityFound(['Project' => 'projectId'])], callback: function ($params) {
                $form = Comment::createForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    ["id" => $userId] = $_SESSION['user'];
                    ["projectId" => $projectId] = $params;
                    $comment = new Comment(array_merge(
                        ["userId" => $userId],
                        ["projectId" => $projectId],
                        ["disabled" => 0],
                        $form->filterPost($_POST)
                    ));
                    $comment->save();
                    $this->router->redirect(params: [
                        "success" => ["Commentaire ajouté avec succès"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/comments/:commentId/disable', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                $form = Comment::disabledCommentForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    ["commentId" => $commentId] = $params;
                    $comment = new Comment([
                        "id" => $commentId,
                        "disabled" => intval($_POST['disabled'])
                    ]);
                    $comment->save();
                    $this->router->redirect(params: [
                        "success" => boolval($_POST['disabled']) ? ["Commentaire désactivé avec succès"] : ["Commentaire réactivé avec succès"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/comments/:commentId/delete', middlewares: [new Authorize(), new IsOwnerOfComment()], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["commentId" => $commentId] = $params;
                if ((new Comment())->delete([["id", "=", $commentId]])) {
                    $this->router->redirect(params: [
                        "success" => ["Commentaire supprimé avec succès !"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => ["Un problème est survenu, impossible de supprimer le commentaire"]
                ]);
            }),
        ];
    }
}
