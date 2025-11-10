<?php
class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$this->normalise($path)] = $handler;
    }

    public function dispatch(string $method, string $uri)
    {
        $path = $this->normalise(parse_url($uri, PHP_URL_PATH) ?? '/');
        if (isset($this->routes[$method][$path])) {
            return call_user_func($this->routes[$method][$path]);
        }
        http_response_code(404);
        include __DIR__ . '/../views/errors/404.php';
        exit;
    }

    private function normalise(string $path): string
    {
        return '/' . trim($path, '/');
    }
}
