<?php


namespace Router;

use Closure;

class Router
{

    public $routes = [];

    public function route($action, Closure $callback)
    {
        $action = trim($action, '/');
        $this->routes[$action] = $callback;
    }

    public function dispatch($url)
    {
        try {

            $parsedUrl = parse_url($url);

            $action = trim($parsedUrl['path'], '/');

            if (substr($action, 0, 4) === 'src/') {
                $action = substr($action, 4);
            }

            if (!isset($this->routes[$action])) {
                throw new \Exception("Sorry there is no such route exists'");
            }
            return call_user_func($this->routes[$action]);

        } catch (\Exception $e) {
            echo json_encode([
                'message' => $e->getMessage()
            ]);
        }
    }
}