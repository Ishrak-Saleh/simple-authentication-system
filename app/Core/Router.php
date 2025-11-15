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
    
    // Check for exact matches first
    $callback = $this->routes[$method][$path] ?? null;
    
    // If no exact match, check for dynamic routes
    if (!$callback) {
        $callback = $this->matchDynamicRoute($path, $method);
    }
    
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
        
        // If we have route parameters, pass them to the method
        if (isset($callback['params'])) {
            echo call_user_func_array([$controller, $methodName], $callback['params']);
        } else {
            echo call_user_func([$controller, $methodName]);
        }
    } else {
        // Handle regular callbacks
        echo call_user_func($callback);
    }
}

private function matchDynamicRoute(string $path, string $method): ?array {
    foreach ($this->routes[$method] as $route => $callback) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        $pattern = "#^" . $pattern . "$#";
        
        if (preg_match($pattern, $path, $matches)) {
            array_shift($matches); // Remove the full match
            
            if (is_array($callback)) {
                $callback['params'] = $matches;
            }
            
            return $callback;
        }
    }
    
    return null;
}
    public function redirect(string $path) {
        header("Location: $path");
        exit;
    }
}