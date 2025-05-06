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
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a href="/login">Login</a>  |
            <a href="/register">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main>
     <!-- Global flash container -->
    <?php if (!empty($flash)): ?>
        <div class="flash">
            <?php foreach ($flash as $type => $msg): ?>
            <div class="flash-<?= htmlspecialchars($type) ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= $content ?? '' ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Camagru</p>
</footer>

</body>
</html>

