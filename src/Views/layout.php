<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= $title ?></title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind Play -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        fontFamily: { sans: ['Inter','ui-sans-serif','system-ui'] },
        extend: {
          colors: {
            'dark-purple': '#2E102A',
            plum:          '#89366E',
            'burnt-orange':'#AC5C28',
            'ou-crimson':  '#86261F',
            'fire-brick':  '#AC2C27',
          }
        }
      }
    }
  </script>

  <!-- Your compiled CSS -->
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-100">

  <header class="bg-plum dark:bg-dark-purple text-white">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/" class="text-2xl font-bold">Camagru</a>
      <nav class="space-x-6 font-medium">
        <a href="/" class="hover:text-burnt-orange transition">Home</a>
        <a href="/gallery" class="hover:text-burnt-orange transition">Gallery</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a href="/editor" class="how:text-fire-brick transition">Snapshot</a>
          <a href="/profile" class="hover:text-fire-brick transition">Profile</a>
          <a href="/logout" class="hover:text-fire-brick transition">Logout</a>
        <?php else: ?>
          <a href="/login" class="hover:text-fire-brick transition">Login</a>
          <a href="/register" class="hover:text-fire-brick transition">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="flex-1 container mx-auto px-6 py-8">
    <?= $content ?>
  </main>

  <footer class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm">
    <div class="container mx-auto px-6 py-4">© <?= date('Y') ?> Camagru</div>
  </footer>

</body>
</html>

