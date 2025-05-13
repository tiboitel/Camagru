<?php
namespace Tiboitel\Camagru\Controllers;

use Tiboitel\Camagru\Helpers\View;
use Tiboitel\Camagru\Helpers\Flash;
use Tiboitel\Camagru\Models\Image;

class GalleryController
{
    public function index()
    {
        // Placeholder “featured” images
        $images = [
            [
                'url'        => '/assets/images/placeholder1.jpg',
                'username'   => 'Alice',
                'created_at' => '2025-05-06',
                'caption'    => 'Sunset over the dunes'
            ],
            [
                'url'        => '/assets/images/placeholder2.jpg',
                'username'   => 'Bob',
                'created_at' => '2025-05-05',
                'caption'    => 'My new camagru filter'
            ],
            [
                'url'        => '/assets/images/placeholder3.jpg',
                'username'   => 'Carol',
                'created_at' => '2025-05-04',
                'caption'    => 'Urban vibes'
            ],
        ];

        View::render('gallery/index', [
            'title'  => 'Home - Camagru',
            'images' => $images
        ]);
    }

    public function gallery()
    {
        // TODO: replace with real DB fetch + pagination
        $images = [ /* … your image rows … */ ];
        $pages   = [1,2,3];      // example pages
        $current = 1;
        $prev    = null;
        $next    = 2;

        View::render('gallery/gallery', [
            'title'   => 'Gallery - Camagru',
            'images'  => $images,
            'pages'   => $pages,
            'current' => $current,
            'prev'    => $prev,
            'next'    => $next,
        ]);
    }

    public function editor()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId)
        {
            http_response_code(403);
            Flash::set(Flash::WARNING, "You are not authorized to go on this page.");
            header('Location: /');
            exit;
        }

        return View::render('gallery/editor', [
            'title' => 'Editor'
        ]);
    }
}

