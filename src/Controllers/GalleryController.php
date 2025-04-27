<?php
namespace Tiboitel\Camagru\Controllers;

use Tiboitel\Camagru\Helpers\View;;

class GalleryController
{
    public function index()
    {
        View::Render('gallery/index', [
            'title' => "Home - Camagru"
        ]);
    }

    public function gallery()
    {
        View::Render('gallery/gallery', [
            'title' => "Gallery - Camagru"
        ]);
    }
}

