<?php

# require_once(__DIR__ . '/../controllers/GalleryController.php');

use Tiboitel\Camagru\Controllers\GalleryController;

/**
 * Basic Routing System for the Camagru Web Application
 * 
 * Routes are mapped to specific controllers and methods.
 */

// Define all routes in a structured array
$routes = [
    'GET' => [
        '/' => [GalleryController::class, 'index'],          // Homepage
        '/login' => [UserController::class, 'showLogin'],    // Login Page
        '/register' => [UserController::class, 'showRegister'], // Registration Page
        '/profile' => [UserController::class, 'profile'],    // User Profile
        '/gallery' => [GalleryController::class, 'index'],   // Gallery Page
        '/image/edit' => [ImageController::class, 'edit'],   // Edit Image
        '/image/view' => [ImageController::class, 'view'],   // View Single Image
    ],
    'POST' => [
        '/login' => [UserController::class, 'login'],        // Handle Login
        '/register' => [UserController::class, 'register'],  // Handle Registration
        '/image/upload' => [ImageController::class, 'upload'], // Handle Image Upload
        '/comment/add' => [CommentController::class, 'add'], // Add Comment
    ],
    'DELETE' => [
        '/image/delete' => [ImageController::class, 'delete'], // Delete Image
        '/comment/delete' => [CommentController::class, 'delete'], // Delete Comment
    ],
];

// Handle the current request
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query string for clean matching

$galeryController = new GalleryController();

// Match the request to the route
if (isset($routes[$requestMethod][$requestUri])) {
    [$controller, $method] = $routes[$requestMethod][$requestUri];

    // Check if the controller and method exist
    if (class_exists($controller) && method_exists($controller, $method)) {
        $controllerInstance = new $controller();
        call_user_func([$controllerInstance, $method]);
    } else {
        http_response_code(500);
        echo "Error: Controller or method not found.";
    }
} else {
    http_response_code(404);
    echo "Error 404: Page not found.";
}

