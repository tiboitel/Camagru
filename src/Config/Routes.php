<?php
namespace Tiboitel\Camagru\Config;

use Tiboitel\Camagru\Router;
use Tiboitel\Camagru\Controllers\GalleryController;

class Routes
{
    public static function register(Router $router): void
    {
        $gallery = new GalleryController();

        $router->get('/', [$gallery, 'index']);
        $router->get('/gallery', [$gallery, 'gallery']);
    }
}

