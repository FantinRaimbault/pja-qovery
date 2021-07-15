<?php

namespace App\Modules\Controllers\Comments\Middlewares;

use App\Core\Router\Middleware;
use App\Modules\Controllers\Comments\Models\Comment;


class IsOwnerOfComment extends Middleware
{

    public function handle($params)
    {
        ["commentId" => $commentId] = $params;
        ["id" => $userId] = $_SESSION['user'];
        $comment = (new Comment())->findOne([
            ["id", "=", $commentId],
            ["userId", "=", $userId],
        ]);
        if(empty($comment)) {
            throw new \Exception("Unauthorized", 403);
        }
    }
}
