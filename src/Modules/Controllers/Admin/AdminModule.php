<?php

namespace App\Modules\Controllers\Admin;

use App\Core\View;
use App\Core\Logger;
use App\Modules\Module;
use App\Modules\Middlewares\Authorize;
use App\Modules\Controllers\Reports\Models\Report;
use App\Modules\Controllers\Bans\UseCases\BanUseCases;
use App\Modules\Controllers\Reports\UseCases\ReportUseCases;

class AdminModule extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(): array
    {
        return [
            $this->router->get('/admin/reports', middlewares: [new Authorize(['admin'])], callback: function($params) {
                $view = new View('admin_reports', ['main_nav'], false);
                $reportedComments = ReportUseCases::getCommentsGroupedByReports();
                $view->assign('reportedComments', $reportedComments);
                $view->show();
            }),

            $this->router->get('/admin/disabled-comments', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                $view = new View('admin_disabled_comments', ['main_nav'], false);
                $reportedComments = ReportUseCases::getCommentsGroupedByReports(1);
                $view->assign('reportedComments', $reportedComments);
                $view->show();
            }),

            $this->router->get('/admin/banned-users', middlewares: [new Authorize(['admin'])], callback: function ($params) {
                $view = new View('admin_banned_users', ['main_nav'], false);
                $bannedUsers = BanUseCases::getBannedUsers();
                $view->assign('bannedUsers', $bannedUsers);
                $view->show();
            })

            
        ];
    }
}
