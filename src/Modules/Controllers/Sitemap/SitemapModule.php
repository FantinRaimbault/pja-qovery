<?php

namespace App\Modules\Controllers\Sitemap;

use App\Core\View;
use App\Modules\Module;
use App\Modules\BinksBeatHelper;
use App\Modules\Controllers\Sitemap\UseCases\SitemapUseCases;

class SitemapModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->get('/sitemap', callback: function (): void {
                $resulat = SitemapUseCases::getURLForPages();
                //echo BinksBeatHelper::showSitemap($resulat);
                $view = new View('sitemap');
                $view->assign("sitemap", $resulat);
                $view->showSitemap();
            })
        ];
    }
} 
