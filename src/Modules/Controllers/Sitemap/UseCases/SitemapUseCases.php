<?php

namespace App\Modules\Controllers\Sitemap\UseCases;

use App\Core\Database\Query;

class SitemapUseCases
{

    public static function getURLForPages() : array
    {
        $q = new Query();
        return $q->table("projects as pro , pages as pag")
            ->select(['pro.slug as ProSlug' , 'pag.slug as PagSlug' , 'pro.name as ProjectName' , 'pag.name as PageName'])
            ->where("pag.isPublished" ,"=" ,1)
            ->join("pro.id", "pag.projectId")
            ->get();
    }

}