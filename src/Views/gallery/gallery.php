<section class="py-12">
  <h2 class="text-3xl font-bold mb-6 text-center">Community Gallery</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Example loop over $images -->
    <?php foreach ($images as $img): ?>
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <img src="<?= htmlspecialchars($img['url']) ?>" alt="User photo" class="w-full h-48 object-cover">
        <div class="p-4">
          <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= htmlspecialchars($img['username']) ?></span>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($img['created_at']) ?></span>
          </div>
          <p class="text-gray-700 dark:text-gray-300 text-sm">
            <?= htmlspecialchars($img['caption'] ?? '') ?>
          </p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <div class="mt-8 flex justify-center space-x-2">
    <!-- loop pages -->
    <a href="?page=<?= $prev ?>" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300">Prev</a>
    <?php foreach ($pages as $p): ?>
      <a href="?page=<?= $p ?>" class="px-3 py-1 <?= $p === $current ? 'bg-plum text-white' : 'bg-gray-200 dark:bg-gray-700' ?> rounded hover:bg-plum hover:text-white"><?= $p ?></a>
    <?php endforeach; ?>
    <a href="?page=<?= $next ?>" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300">Next</a>
  </div>
</section>
