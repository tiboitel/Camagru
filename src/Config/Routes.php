<?php
namespace Tiboitel\Camagru\Config;

use Tiboitel\Camagru\Router;
use Tiboitel\Camagru\Controllers\GalleryController;
use Tiboitel\Camagru\Controllers\UserController;

class Routes
{
    public static function register(Router $router): void
    {
        $gallery = new GalleryController();
        $user = new UserController();

        $router->get('/', [$gallery, 'index']);
        $router->get('/gallery', [$gallery, 'gallery']);
        $router->get('/editor', [$gallery, 'editor']);
        $router->post('/editor', [$gallery, 'editor']);
        $router->get('/register', [$user, 'register']);
        $router->post('/register', [$user, 'register']);
        $router->get('/confirm', [$user, 'confirm']);
        $router->get('/login', [$user, 'login']);
        $router->post('/login', [$user, 'login']);
        $router->get('/logout', [$user, 'logout']);
        $router->get('/password/forgot', [$user, 'forgot']);
        $router->post('/password/forgot', [$user, 'forgot']);
        $router->get('/password/reset', [$user, 'reset']);
        $router->post('/password/reset', [$user, 'reset']);
        $router->get('/profile', [$user, 'profile']);
        $router->post('/profile', [$user, 'profile']);
    }
}

