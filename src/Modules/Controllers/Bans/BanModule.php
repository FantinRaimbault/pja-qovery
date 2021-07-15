<?php

namespace App\Modules\Controllers\Bans;

use App\Core\Logger;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Controllers\Bans\Models\Ban;
use App\Modules\Controllers\Reports\Models\Report;

class BanModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->post('/bans/:banId', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                $form = Ban::createForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    ['banId' => $banId] = $params;
                    $ban = new Ban(array_merge(
                        ["id" => $banId],
                        $form->filterPost($_POST)
                    ));
                    $ban->save();
                    $this->router->redirect(params: [
                        "success" => ["Sanction modifié avec succès"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/bans/users/:userId', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                $form = Ban::createForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    ['userId' => $userId] = $params;
                    $ban = new Ban(array_merge(
                        ["userId" => $userId],
                        $form->filterPost($_POST)
                    ));
                    $ban->save();
                    $this->router->redirect(params: [
                        "success" => ["Utilisateur sanctionné avec succès"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            }),

            $this->router->post('/bans/users/:userId/delete', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                if ($_SESSION['csrf'] !== $_POST['csrf']) {
                    throw new \Exception("CSRF", 401);
                }
                ["userId" => $userId] = $params;
                if ((new Ban())->delete([["userId", "=", $userId]])) {
                    $this->router->redirect(params: [
                        "success" => ["Utilisateur débanni avec succès !"]
                    ]);
                }
                $this->router->redirect(params: [
                    "errors" => ["Un problème est survenu, impossible de débannir l'utilisateur"]
                ]);
            })
        ];
    }
}
