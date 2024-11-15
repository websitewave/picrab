<?php
// core/Router.php

class Router
{
    private $routes = [];


    public function add($route, $callback)
    {
        $route = trim($route, '/');
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $callback;
    }

    public function dispatch()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = trim($url, '/');

        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                if (is_callable($callback)) {
                    return call_user_func_array($callback, array_slice($params, 1));
                } elseif (is_array($callback)) {
                    $controller = $callback[0];
                    $method = $callback[1];
                    return call_user_func_array([$controller, $method], array_slice($params, 1));
                }
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}