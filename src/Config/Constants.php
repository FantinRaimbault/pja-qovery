<?php

namespace App\Config;

class Constants
{
    public static function get()
    {
        return [
            "users" => [
                "roles" => [
                    "admin" => "admin",
                    "basic" => "basic"
                ]
            ]
        ];
    }
}
