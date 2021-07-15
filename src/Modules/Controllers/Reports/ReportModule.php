<?php

namespace App\Modules\Controllers\Reports;

use App\Core\Logger;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Controllers\Reports\Models\Report;

class ReportModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->post('/reports/comments/:commentId', middlewares: [new Authorize()], callback: function ($params) {
                $form = Report::createForm();
                $errors = $form->getErrors($_POST);
                if (empty($errors)) {
                    ["id" => $userId] = $_SESSION['user'];
                    ["commentId" => $commentId] = $params;
                    $comment = new Report(array_merge(
                        ["userId" => $userId],
                        ["commentId" => $commentId],
                        $form->filterPost($_POST)
                    ));
                    try {
                        $comment->save();
                        $this->router->redirect(params: [
                            "success" => ["Signalement envoyé avec succès"]
                        ]);
                    } catch (\Exception $e) {
                        switch ($e->getCode()) {
                            case 409:
                                $errors[] = "Vous avez déjà signalé ce commentaire";
                                break;
                            default:
                                throw $e;
                        }
                    }
                }
                $this->router->redirect(params: [
                    "errors" => $errors
                ]);
            })
        ];
    }
}
