<section class="min-h-[60vh] flex flex-col items-center justify-center">
  <h1 class="text-6xl font-extrabold mb-4">Oops!</h1>
  <p class="text-xl text-gray-600 dark:text-gray-400 mb-6">
    <?php if (basename(__FILE__) === '404.php'): ?>
      404 — Page Not Found
    <?php else: ?>
      500 — Internal Server Error
    <?php endif; ?>
  </p>
  <a href="/" class="inline-block bg-plum hover:bg-fire-brick text-white font-semibold py-2 px-4 rounded-lg transition">
    Back to Home
  </a>
</section>
