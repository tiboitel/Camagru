<?php

declare(strict_types=1);

namespace Tiboitel\Camagru;

use Tiboitel\Camagru\Router;
use Tiboitel\Camagru\Psr\Http\Message\ResponseInterface;
use Tiboitel\Camagru\Psr\Http\Message\ServerRequestInterface;

class App
{
    private Router $router;

    public function __construct()
    {
        echo "App constructor called\n";
        $this->router = new Router();
    }

    /**
     * Register routes and middlewares in the application.
     *
     * @param callable $routeConfig A callback function to define routes.
     */
    public function registerRoutes(callable $routeConfig): void
    {
        $routeConfig($this->router);
    }

    /**
     * Dispatch the router and return the response.
     */
    public function run(): void
    {
        // Create a PSR-7 compliant request and response
        $request = ServerRequest::fromGlobals();
        $response = new Response();

        // Dispatch the router and get the response
        $response = $this->router->dispatch($request, $response);

        // Send the response back to the client
        $this->sendResponse($response);
    }

    /**
     * Outputs the response to the client.
     *
     * @param ResponseInterface $response
     */
    private function sendResponse(ResponseInterface $response): void
    {
        // Send HTTP status line
        header(sprintf('HTTP/%s %d %s', '1.1', $response->getStatusCode(), $response->getReasonPhrase()));

        // Send headers
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        // Send the body
        echo $response->getBody();
    }
}

