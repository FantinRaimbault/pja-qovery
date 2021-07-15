<?php

namespace App\Modules\Controllers\Reports\UseCases;

use App\Core\Database\Query;


class ReportUseCases
{
    public static function getCommentsGroupedByReports($disabled = 0)
    {
        $q = new Query();
        return $q->table('comments as c, reports as r, projects as p, users as u')
            ->select([
                'c.id as commentId', 'c.content as content', 'c.disabled as disabled',
                'COUNT(*) as nbReports', 'p.name as projectName', 'p.id as projectId',
                'u.firstname as username', 'u.id as userId', 'c.createdAt as createdAt'
            ])
            ->where('c.disabled', '=', $disabled)
            ->join('c.id', 'r.commentId')
            ->join('c.projectId', 'p.id')
            ->join('c.userId', 'u.id')
            ->groupBy('commentId')
            ->orderBy('nbReports DESC')
            ->get() ?? [];
    }
}
