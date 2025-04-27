<?php
namespace Tiboitel\Camagru\Config;

use Tiboitel\Camagru\Router;
use Tiboitel\Camagru\Controllers\GalleryController;

function setRoutesConfig(Router $router)
{
    $gallery = new GalleryController();

    $router->get('/', [$gallery, 'index']);
    $router->get('/gallery', [$gallery, 'gallery']);
}
>
