<?php
namespace Tiboitel\Camagru;

use Tiboitel\Camagru\Helpers\View;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes[$method] ?? [] as $path => $handler) {
            if ($path === $uri) {
                call_user_func($handler);
                return;
            }
        }

        $this->handleNotFound();
    }

    private function handleNotFound(): void
    {
        http_response_code(404);
        View::render('errors/404', [
            'title' => "404 error - Camagru"
        ]);
    }
}

