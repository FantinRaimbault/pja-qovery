<?php

namespace App\Core\Router;

use Closure;

class Route
{
    private string $path;
    private array $middlewares;
    private Closure $callback;
    private array $matches;

    public function __construct(string $path, array $middlewares, Closure $callback)
    {
        $this->path = trim($path, '/');
        $this->middlewares = $middlewares;
        $this->callback = $callback;
        $this->matches = [];
    }

    public function match(string $url): bool
    {
        $url = trim($url, "/");
        $path = preg_replace("#:([\w]+)#", '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        // here, $matches = Array ( [0] => users/1/name/fantin/age/13 [1] => 1 [2] => fantin [3] => 13 )
        // we need to remove first value
        array_shift($matches);
        if (!empty($matches)) {
            preg_match_all("#:([\w]+)#", $this->path, $namedParams);
            array_shift($namedParams);
            // bind namedParams by its value : [ "id" => 1, "name" => "fantin", "age" => 13 ]
            for ($i = 0; $i < count($namedParams[0]); $i++) {
                $this->matches[$namedParams[0][$i]] = $matches[$i];
            }
        }

        return true;
    }

    public function addMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function setPath(string $path)
    {
        $this->path = trim($path, '/');
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function call()
    {
        foreach ($this->middlewares as $middleware) {
            $middleware->handle($this->matches);
        }
        return call_user_func($this->callback, $this->matches);
    }
}
