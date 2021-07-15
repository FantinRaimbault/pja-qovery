<?php

namespace App\Core\Router;

use App\Core\Logger;
use Closure;
use Error;
use App\Core\View;

class Router
{
    private static array $httpMethods = ["GET", "POST", "PUT", "DELETE"];
    private static $router;

    private string $url;
    private array $routes;
    private array $middlewares;

    public static function getInstance(): Router
    {
        if (is_null(self::$router)) {
            self::$router = new Router($_GET['url']);
        }
        return self::$router;
    }

    private function __construct($url)
    {
        $this->url = $url;
        $this->routes = [];
        $this->middlewares = [];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function get(string $path, array $middlewares = [], Closure $callback): Route
    {
        $route = new Route($path, $middlewares, $callback);
        $this->routes['GET'][] = $route;
        return $route;
    }

    public function post(string $path, array $middlewares = [], Closure $callback): Route
    {
        $route = new Route($path, $middlewares, $callback);
        $this->routes['POST'][] = $route;
        return $route;
    }

    public function match(array $httpMethods = ["get", "post", "put", "delete"], string $path, array $middlewares = [], Closure $callback): Route
    {
        $route = new Route($path, $middlewares, $callback);
        foreach ($httpMethods as $httpMethod) {
            $httpMethodUppercase = mb_strtoupper($httpMethod);
            if (!in_array($httpMethodUppercase, self::$httpMethods)) {
                throw new \Exception("wrong httpMethode for match Router.");
            }
            $this->routes[$httpMethodUppercase][] = $route;
        }
        return $route;
    }

    /**
     * @param String $path
     * @param String $module ;
     */
    public function use(string $path = "", string $module)
    {
        $currentModule = new $module();
        foreach ($currentModule->routes() as $route) {
            if (!empty($path)) {
                $route->setPath(trim($path, '/') . '/' . $route->getPath());
            }
        }
    }

    public function addMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }


    private function applyMiddlewares(Route $route)
    {
        foreach ($this->middlewares as $middleware) {
            $route->addMiddleware($middleware);
        }
    }

    public function run()
    {
        if (!$this->routes[$_SERVER['REQUEST_METHOD']]) {
            echo 'request method not found';
            return 0;
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                $this->applyMiddlewares($route);
                return $route->call();
            }
        }
        throw new \Exception('Not found', 404);
        //$view = new View('404');
        //$view->show();
    }

    public function redirect(string $path = null, $params = [])
    {
        // if $path -> start at beginning
        // else HTTP_REFERER ->  where was user when he want to access this route, ex: if i was on
        // localhost:9000/users/login and i make a POST request on /user/toto
        // HTTP_REFERER = /user/login
        $pathFrom = $path ?? "/" . explode("/", preg_replace('/^http:\/\//', '', $_SERVER["HTTP_REFERER"]), 2)[1];
        $queryParams = '?';
        foreach ($params as $key => $value) {
            $queryParams .= $key . "=" . join(',', $value) . "&";
        }
        header("Location: " . $pathFrom . $queryParams);
        exit();
    }

    /**
     * Go is used to put link in href.
     * @example if you are in a route like mysite.com/toto/titi.
     * Router::go('/tete'); --> the whole path in href is : /toto/titi/tete.
     * Router::go('..'); --> the whole path in href is : /toto.
     * Router::go('~/tata'); --> the whole path in href is : /tata
     *
     * @param string $path
     * @return void
     */
    public static function go(string $path): void {
        if(substr($path, 0, 1) === '~') {
            echo substr($path, 1);
            return;
        }
        $currentPath = trim($_SERVER['REDIRECT_URL'], "/");
        $explodedCurrentPath = explode("/", $currentPath);
        $trimedPath = trim($path, "/");
        $explodedTrimedPath = explode("/", $trimedPath);
        forEach($explodedTrimedPath as $path) {
            if($path === "..") {
                array_pop($explodedCurrentPath);
            } else {
                $explodedCurrentPath[] = $path;
            }
        }
        $newPath = "/" . rtrim(join("/", $explodedCurrentPath));
        echo $newPath;
    }

    public static function setRoute(string $target, string $new): void {
        $currentPath = trim($_SERVER['REDIRECT_URL'], "/");
        $explodedCurrentPath = explode("/", $currentPath);
        $targetIndex = array_search($target, $explodedCurrentPath);
        $explodedCurrentPath[$targetIndex + 1] = $new;
        echo "/" . rtrim(join("/", $explodedCurrentPath));
    }

}
