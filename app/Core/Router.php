<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, array $action): void { $this->routes['GET'][$path] = $action; }
    public function post(string $path, array $action): void { $this->routes['POST'][$path] = $action; }

    public function dispatch(string $method, string $path): void {
        $action = $this->routes[$method][$path] ?? null;
        if (!$action) {
            http_response_code(404);
            echo 'Ruta no encontrada';
            return;
        }
        [$controllerClass, $controllerMethod] = $action;
        $controller = new $controllerClass();
        $controller->$controllerMethod();
    }
}
