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
        $router->get('/register', [$user, 'showRegisterForm']);
        $router->post('/register', [$user, 'register']);
        $router->get('/confirm', [$user, 'confirmAccount']);
        $router->get('/login', [$user, 'showLoginForm']);
        $router->post('/login', [$user, 'login']);
        $router->get('/logout', [$user, 'logout']);
        $router->get('/password/forgot', [$user, 'showForgotForm']);
        $router->post('/password/forgot', [$user, 'sendResetEmail']);
        $router->get('/password/reset', [$user, 'showResetForm']);
        $router->post('/password/reset', [$user, 'resetPassword']);
        $router->get('/profile', [$user, 'showProfile']);
        $router->post('/profile', [$user, 'updateProfile']);
    }
}

