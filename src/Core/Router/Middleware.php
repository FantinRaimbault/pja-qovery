<?php


namespace App\Core\Router;

abstract class Middleware
{
    // return 0 = success, 1 = error
    abstract function handle($params);
}