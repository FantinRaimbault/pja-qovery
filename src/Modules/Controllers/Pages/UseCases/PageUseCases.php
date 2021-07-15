<?php

namespace App\Modules\Controllers\Pages\UseCases;

use App\Core\Database\Query;


class PageUseCases
{
    public static function getPageBySlugProjectAndSlugPage(string $slugProject, string $slugPage)
    {
        $q = new Query();
        return $q->table('projects as pro, pages as pag')
            ->where('pro.slug', '=', $slugProject)
            ->select(['pag.content', 'pag.isPublished', 'pag.backgroundColor', 'pag.seoDescription', 'pag.seoTitle', 'pro.id as projectId'])
            ->where('pag.slug', '=', $slugPage)
            ->join('pro.id', 'pag.projectId')
            ->get()[0] ?? [];
    }

    public static function checkIsMain(string $projectId)
    {
        $q = new Query();
        return $q->table('pages')
            ->select(['isMain'])
            ->where('projectId', '=', $projectId)
            ->join('isMain', 1)
            ->get()[0]["isMain"] ?? 0;
    }
}
