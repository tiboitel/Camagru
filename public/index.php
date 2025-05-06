<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Autoloader.php';

use Tiboitel\Camagru\Autoloader;
use Tiboitel\Camagru\App;
use Tiboitel\Camagru\Config\Routes;

$autoloader = new Autoloader();
$autoloader->register();
$autoloader->addNamespace('Tiboitel\Camagru', __DIR__ . '/../src/');

$app = new App();

//try {
    // Register routes
    $app->registerRoutes(function($router) {
        Routes::register($router);
    });

    $app->run();
/*} catch (Throwable $e) {
    http_response_code(500);
    require __DIR__ . '/../src/Views/errors/500.php';
    error_log($e->getMessage());
    }*/

