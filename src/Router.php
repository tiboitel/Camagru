<?php

namespace Tiboitel\Camagru;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private string $basePath = '';

    public function setBasePath(string $basePath): void
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, callable $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, callable $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    public function group(string $prefix, callable $group): void
    {
        $currentBasePath = $this->basePath;
        $this->basePath .= '/' . trim($prefix, '/');
        $group($this);
        $this->basePath = $currentBasePath; // Reset the base path after group
    }

    public function middleware(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function dispatch(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $method = $request->getMethod();
        $uri = '/' . trim($request->getUri()->getPath(), '/');

        foreach ($this->routes as $route) {
            if ($this->match($route['path'], $uri, $params) && $method === $route['method']) {
                foreach ($this->middlewares as $middleware) {
                    $response = $middleware($request, $response);
                }

                // Inject route parameters into the request object
                if (!empty($params)) {
                    $request = $request->withAttribute('params', $params);
                }

                return $route['handler']($request, $response);
            }
        }

        // If no match is found, return a 404 response
        return $response->withStatus(404)->withBody(\GuzzleHttp\Psr7\Utils::streamFor('404 Not Found'));
    }

    private function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $this->basePath . '/' . trim($path, '/'),
            'handler' => $handler,
        ];
    }

    private function match(string $routePath, string $requestUri, &$params): bool
    {
        $params = [];
        $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $routePath); // Convert route parameters into regex
        $pattern = "#^" . rtrim($pattern, '/') . "$#";

        if (preg_match($pattern, $requestUri, $matches)) {
            foreach ($matches as $key => $value) {
                if (!is_int($key)) {
                    $params[$key] = $value;
                }
            }
            return true;
        }
        return false;
    }
}

