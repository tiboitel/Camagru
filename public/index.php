<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/Autoloader.php';

use Tiboitel\Camagru\Autoloader;
use Tiboitel\Camagru\App;
use Tiboitel\Camagru\Config\Routes;

$autoloader = new Autoloader();
$autoloader->register();
$autoloader->addNamespace('Tiboitel\Camagru', __DIR__ . '/../src/');

$app = new App();

// Register routes
$app->registerRoutes(function($router) {
    Routes::register($router);
});

$app->run();

