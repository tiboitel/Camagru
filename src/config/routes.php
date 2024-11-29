<?php
use Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

// Instantiate the router

function setRoutesConfig(Router $router) {

    // Define base URI path
    $router->setBasePath('/');
   
   // Define routes
    $router->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Welcome to Camagru!');
        return $response;
    });

    $router->get('/gallery', function (Request $request, Response $response) {
        $response->getBody()->write('Gallery Page');
        return $response;
    });

    $router->get('/user/{id}', function (Request $request, Response $response) {
        $params = $request->getAttribute('params');
        $response->getBody()->write('User ID: ' . $params['id']);
        return $response;
    });

    // Middleware example
    $router->middleware(function (Request $request, Response $response) {
        // Example: Basic logging middleware
        error_log($request->getMethod() . ' ' . $request->getUri());
        return $response;
    });

    // Register the routes in a group
    $router->group('admin', function (Router $router) {
        $router->get('/dashboard', function (Request $request, Response $response) {
            $response->getBody()->write('Admin Dashboard');
            return $response;
        });
    });
}
?>
