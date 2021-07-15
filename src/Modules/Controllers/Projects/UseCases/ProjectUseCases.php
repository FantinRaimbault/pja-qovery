<?php

namespace App\Modules\Controllers\Projects\UseCases;

use App\Core\Database\Query;
use App\Modules\Controllers\Auth\Models\User;
use App\Modules\Controllers\Auth\Models\Contributor;

class ProjectUseCases
{
    public static function isUserContributorOfProject(string $email, int $projectId)
    {
        ["id" => $userId] = (new User())->findOne([
            ["email", "=", $email]
        ]);
        $contributor = (new Contributor())->findOne([
            ["userId", "=", $userId],
            ["projectId", "=", $projectId]
        ]);
        return !!$contributor;
    }

    public static function getProjectsByUserId(int $userId): array
    {
        $q = new Query();
        return $q->table("contributors as c, projects as p")
            ->where('c.userId', '=', $userId)
            ->join("c.projectId", "p.id")
            ->get();
    }

    public static function getInvitationsByEmailPopulateProjects(string $email)
    {
        $q = new Query();
        return $q->table("invitations as i, projects as p")
            ->select(['i.id as invitationId', 'p.id as projectId', 'p.name as projectName', 'p.picture as projectPicture'])
            ->where('i.email', '=', $email)
            ->join("i.projectId", "p.id")
            ->get();
    }

    public static function getContributorsByProjectId(int $projectId)
    {
        $q = new Query();
        return $q->table("contributors as c, users as u")
            ->select(['u.id as userId', 'u.firstname', 'u.lastname', 'u.email', 'c.role'])
            ->where('c.projectId', '=', $projectId)
            ->join("c.userId", "u.id")
            ->get();
    }

    public static function getCommentsProjectPopulateUser(int $projectId)
    {
        $q = new Query();
        return $q->table("users as u, comments as c")
            ->select(['c.id as commentId', 'c.content as content', 'c.createdAt as createdAt', 'u.firstname as firstname', 'u.picture as picture', 'u.id as userId'])
            ->where('c.projectId', '=', $projectId)
            ->where('c.disabled', '=', 0)
            ->join('c.userId', 'u.id')
            ->orderBy('c.createdAt DESC')
            ->get();
    }

    public static function getProjectPopulateOwner(int $projectId)
    {
        $q = new Query();
        return $q->table("users as u, projects as p")
            ->select(['p.id as projectId', 'p.name as name', 'p.description as description', 'p.slug as slug', 'p.picture as picture', 'u.firstname as owner_firstname'])
            ->where('p.id', '=', $projectId)
            ->join('u.id', 'p.owner')
            ->get()[0] ?? [];
    }

    public static function getCommunityProjectsPopulateOwner()
    {
        $q = new Query();
        return $q->table("users as u, projects as p , pages as pag")
        ->select(['p.id as projectId', 'p.name', 'p.description', 'p.slug', 'u.firstname as owner_firstname' , 'pag.slug as PSLUG', 'p.picture as picture'])
        ->where('p.allowCommunity', '=', 1)
            ->join('u.id', 'p.owner')
            ->join('pag.projectId', 'p.id')
            ->join('u.id', 'p.owner')
            ->get();
    }
}
