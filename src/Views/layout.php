<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Camagru' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="/">Home</a> | 
        <a href="/gallery">Gallery</a> | 
        <a href="/login">Login</a>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Camagru</p>
</footer>

</body>
</html>

