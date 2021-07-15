<?php

namespace App\Modules;

use App\Core\Router\Router;

abstract class Module {

    protected Router $router;

    protected function __construct() {
        $this->router = Router::getInstance();
    }

    abstract function routes(): array;
}