<?php

namespace App\Modules\Controllers\Bans\UseCases;

use App\Core\Database\Query;


class BanUseCases
{
    public static function getBannedUsers()
    {
        $q = new Query();
        return $q->table('bans as a LEFT OUTER JOIN bans as b ON a.userId = b.userId AND a.createdAt < b.createdAt, users as u')
            ->select(['a.id as banId', 'a.reason as reason', 'a.createdAt as createdAt', 'a.until as until', 'a.userId as userId', 'u.firstname as username', 'u.email as email'])
            ->where('b.userId', 'IS', NULL)
            ->orderBy('a.createdAt DESC')
            ->join('u.id', 'a.userId')
            ->get() ?? [];
    }

    public static function getLatestBanishmentOfUser($userId) {
        $q = new Query();
        return $q->table('bans as b')
        ->where('b.userId', '=', $userId)
        ->orderBy('b.createdAt DESC')
        ->limit(1)
        ->get()[0] ?? [];
    }
}
