<?php
require_once __DIR__ . '/../Autoloader.php';

use Tiboitel\Camagru\Autoloader;
use Tiboitel\Camagru\App;

$autoloader = new Autoloader();
$autoloader->register();
$autoloader->addNamespace("Tiboitel\Camagru", __DIR__ . "/../../src");

$app = new App();
$app->run();
?>
