<section class="py-12">
  <h2 class="text-3xl font-bold mb-6 text-center">Featured Creations</h2>
  <?php require_once('../src/Views/partials/flash.php'); ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($images as $img): ?>
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <img src="<?= htmlspecialchars($img['url']) ?>"
             alt="<?= htmlspecialchars($img['caption']) ?>"
             class="w-full h-44 object-cover">
        <div class="p-4">
          <div class="flex items-center justify-between mb-2 text-sm text-gray-500 dark:text-gray-400">
            <span><?= htmlspecialchars($img['username']) ?></span>
            <span><?= htmlspecialchars($img['created_at']) ?></span>
          </div>
          <p class="text-gray-700 dark:text-gray-300 text-sm">
            <?= htmlspecialchars($img['caption']) ?>
          </p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="mt-10 text-center">
    <a href="/gallery"
       class="inline-block bg-plum hover:bg-fire-brick text-white font-semibold py-3 px-6 rounded-lg transition">
      View All Photos
    </a>
  </div>
</section>

