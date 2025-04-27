<?php
namespace Tiboitel\Camagru;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function registerRoutes(callable $callback): void
    {
        $callback($this->router);
    }

    public function run(): void
    {
        $this->router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}

