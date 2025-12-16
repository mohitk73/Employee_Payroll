<?php
 
namespace App\Core;
 
class Router {
 
    private array $routes = [];
 
    public function get(string $path, callable|array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }
 
    public function post(string $path, callable|array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }
 
    public function patch(string $path, callable|array $handler): void {
        $this->routes['patch'][$path] = $handler;
    }
 
    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // path define
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
 
        if(isset($this->routes[$method][$uri])){
            $handler = $this->routes[$method][$uri];
            
            if(is_array($handler)){
                [$class, $method] = $handler;
                $controller = new $class;
                $controller->$method();
                return;
            }
 
            $handler();
            return;
        }
 
        http_response_code(404);
        echo "404 Not found";
    }
}