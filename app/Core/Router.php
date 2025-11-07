<?php
namespace app\Core;

class Router {
    private array $routes = [];

    // Remove "callable" type hint to allow arrays
    public function get(string $path, $callback): void {
        $this->routes['GET'][$path] = $callback;
    }

    // Remove "callable" type hint to allow arrays
    public function post(string $path, $callback): void {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(string $uri, string $method): void {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        
        // Remove the base path (everything before /public/)
        $basePath = '/metro_wb_lab/public';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        // Ensure path starts with /
        if (empty($path) || $path[0] !== '/') {
            $path = '/' . $path;
        }
        
        $callback = $this->routes[$method][$path] ?? null;
        
        if (!$callback) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>Path: $path</p>";
            echo "<p>Available routes:</p>";
            echo "<pre>" . print_r($this->routes[$method] ?? [], true) . "</pre>";
            return;
        }

        // Handle arrays like [Controller::class, 'method']
        if (is_array($callback)) {
            $className = $callback[0];
            $methodName = $callback[1];
            $controller = new $className();
            echo call_user_func([$controller, $methodName]);
        } else {
            // Handle regular callbacks
            echo call_user_func($callback);
        }
    }

    public function redirect(string $path) {
        header("Location: $path");
        exit;
    }
}