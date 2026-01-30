<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function add($method, $path, $handler) {
        $this->routes[] = ['method' => strtoupper($method), 'path' => $path, 'handler' => $handler];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && preg_match($this->pathToRegex($route['path']), $uri, $matches)) {
                array_shift($matches); // Remove full match
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    private function pathToRegex($path) {
        return '#^' . preg_replace('/\{(\w+)\}/', '([^/]+)', $path) . '$#';
    }
}