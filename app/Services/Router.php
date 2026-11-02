<?php
declare(strict_types=1);

namespace App\Services;

use RuntimeException;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private array $currentGroupMiddlewares = [];

    public function get(string $path, array|callable $handler, array $middlewares = []): self
    {
        return $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, array|callable $handler, array $middlewares = []): self
    {
        return $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function group(array $middlewares, callable $callback): void
    {
        $previousMiddlewares = $this->currentGroupMiddlewares;
        $this->currentGroupMiddlewares = array_merge($this->currentGroupMiddlewares, $middlewares);

        $callback($this);

        $this->currentGroupMiddlewares = $previousMiddlewares;
    }

    private function addRoute(string $method, string $path, array|callable $handler, array $middlewares = []): self
    {
        $path = '/' . trim($path, '/');
        $allMiddlewares = array_merge($this->currentGroupMiddlewares, $middlewares);

        // Convert {param} placeholders to regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'regex' => $regex,
            'handler' => $handler,
            'middlewares' => $allMiddlewares,
        ];

        return $this;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        $uri = $this->resolveRequestUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $uri, $matches)) {
                // Filter named parameters only
                $params = array_filter($matches, fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY);

                // Run Middlewares
                foreach ($route['middlewares'] as $mw) {
                    $this->runMiddleware($mw);
                }

                $this->executeHandler($route['handler'], $params);
                return;
            }
        }

        // No match found -> 404
        $this->handleNotFound();
    }

    private function resolveRequestUri(): string
    {
        // 1. Query parameter fallback (?r=/path or ?route=/path)
        if (isset($_GET['r']) && !empty($_GET['r'])) {
            $uri = '/' . ltrim($_GET['r'], '/');
            return strtok($uri, '?');
        }
        if (isset($_GET['route']) && !empty($_GET['route'])) {
            $uri = '/' . ltrim($_GET['route'], '/');
            return strtok($uri, '?');
        }

        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($requestUri, PHP_URL_PATH) ?? '/';

        // Strip known base path or subdirectory if present
        if (str_starts_with($uri, '/kcet/public')) {
            $uri = substr($uri, strlen('/kcet/public'));
        }

        // Strip script name or directory if running in subdirectory
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $scriptDir = dirname($scriptName);

        if ($scriptDir !== '/' && $scriptDir !== '\\' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        if (str_starts_with($uri, '/index.php')) {
            $uri = substr($uri, strlen('/index.php'));
        }

        $uri = '/' . trim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    private function runMiddleware(string $middleware): void
    {
        [$name, $param] = array_pad(explode(':', $middleware, 2), 2, null);

        switch ($name) {
            case 'auth':
                \App\Middleware\AuthMiddleware::handle();
                break;
            case 'role':
                \App\Middleware\AuthMiddleware::requireRole(explode(',', (string)$param));
                break;
            case 'csrf':
                \App\Middleware\CsrfMiddleware::handle();
                break;
            case 'rate_limit':
                \App\Middleware\RateLimitMiddleware::handle($param ?? 'general');
                break;
        }
    }

    private function executeHandler(array|callable $handler, array $params): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_array($handler)) {
            [$class, $method] = $handler;
            if (!class_exists($class)) {
                throw new RuntimeException("Controller class not found: {$class}");
            }
            $controller = new $class();
            if (!method_exists($controller, $method)) {
                throw new RuntimeException("Method {$method} not found in controller {$class}");
            }
            call_user_func_array([$controller, $method], $params);
            return;
        }

        throw new RuntimeException("Invalid route handler format.");
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        try {
            $controller = new \App\Controllers\PageController();
            $controller->notFound();
        } catch (\Throwable) {
            echo "<h1>404 Not Found</h1><p>The requested page could not be found.</p><p><a href='" . url('/') . "'>Return to Homepage</a></p>";
        }
    }
}

