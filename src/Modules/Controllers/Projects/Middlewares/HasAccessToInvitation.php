<?php

namespace App\Modules\Controllers\Projects\Middlewares;

use App\Core\Router\Middleware;
use App\Modules\Controllers\Projects\Models\Invitation;

class HasAccessToInvitation extends Middleware
{

    public function handle($params)
    {
        [
            'invitationId' => $invitationId,
            'projectId' => $projectId
        ] = $params;

        ['email' => $email] = $_SESSION['user'];

        $invitation = (new Invitation())->findOne([
            ['email', '=', $email],
            ['id', '=', $invitationId],
            ['projectId', '=', $projectId]
        ]);
        if (!$invitation) {
            throw new \Exception('Project not found', 404);
        }
    }
}
